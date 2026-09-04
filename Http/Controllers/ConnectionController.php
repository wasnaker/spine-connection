<?php

declare(strict_types=1);

namespace Modules\Connection\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Connection\Models\Connection;
use Modules\Connection\Services\ActorResolver;

/**
 * Connection — relasi customer <-> surveyor via invite link.
 *
 * Flow:
 *   POST /api/v1/connections                  -> buat link (pending, sisi pengirim)
 *   GET  /api/v1/connections                  -> daftar connection milik entity aktif
 *   GET  /api/v1/connections/{token}          -> info link (utk halaman approve)
 *   POST /api/v1/connections/{token}/approve  -> approve (isi sisi lawan + active)
 *   POST /api/v1/connections/{id}/cancel      -> batalkan pending (oleh pembuat)
 *
 * Aturan:
 *   - customer-world hanya connect ke surveyor-world (dan sebaliknya).
 *   - satu pasangan (customer_id, surveyor_id) hanya boleh 1 connection
 *     active/pending — generate/approve duplikat -> 409.
 *   - siapa yang mengirim link bebas (customer->surveyor / surveyor->customer).
 */
class ConnectionController extends Controller
{
    public function __construct(private readonly ActorResolver $actors)
    {
    }

    /**
     * Daftar connection milik entity aktif (sebagai customer ATAU surveyor).
     */
    public function index(Request $request): JsonResponse
    {
        $actor = $this->actors->resolve($request->user());

        $query = Connection::with([
            'customer:id,code,name,type,parent_id',
            'customer.parent:id,code,name',
            'surveyor:id,code,name,type,parent_id',
            'surveyor.parent:id,code,name',
            'creator:id,name',
            'approver:id,name',
        ]);

        if ($actor['type'] === 'customer') {
            $query->where('customer_id', $actor['entity']->id);
        } elseif ($actor['type'] === 'surveyor') {
            $query->where('surveyor_id', $actor['entity']->id);
        }
        // Actor null = platform (admin/staff pemegang connection:view):
        // lihat SEMUA connection. Filter hanya utk user entity.

        if ($request->filled('status') && in_array($request->query('status'), ['pending', 'active', 'cancelled'])) {
            $query->where('status', $request->query('status'));
        }

        return response()->json(['data' => $query->orderByDesc('id')->get()]);
    }

    /**
     * Generate invite link — row pending dengan sisi pengirim terisi.
     */
    public function store(Request $request): JsonResponse
    {
        $actor = $this->actors->resolve($request->user());
        $type = $actor['type'];

        if (! $type || ! $actor['entity']) {
            return response()->json(['message' => 'Akun tidak terikat ke entity customer/surveyor.'], 403);
        }

        // Entity non-aktif tidak boleh membuat link.
        if (! $actor['entity']->is_active) {
            return response()->json(['message' => 'Entity non-aktif tidak bisa membuat link.'], 422);
        }

        $existing = Connection::where($type . '_id', $actor['entity']->id)
            ->where('status', 'pending')
            ->exists();
        if ($existing) {
            return response()->json(['message' => 'Masih ada link pending — gunakan link yang sudah ada atau batalkan dulu.'], 409);
        }

        $connection = Connection::create([
            'token'       => Str::random(48),
            $type . '_id' => $actor['entity']->id,
            'status'      => 'pending',
            'created_by'  => $request->user()->id,
        ]);

        Log::info('[Connection] created', ['id' => $connection->id, 'by' => $type, 'entity_id' => $actor['entity']->id]);

        return response()->json($this->present($connection), 201);
    }

    /**
     * Info link by token — dipakai halaman approve (harus login dulu).
     */
    public function show(string $token): JsonResponse
    {
        $connection = Connection::with(['customer:id,code,name,type', 'surveyor:id,code,name,type'])->where('token', $token)->first();

        if (! $connection) {
            return response()->json(['message' => 'Link tidak ditemukan.'], 404);
        }
        if ($connection->status !== 'pending') {
            return response()->json(['message' => 'Link sudah tidak berlaku (status: ' . $connection->status . ').'], 422);
        }

        return response()->json($this->present($connection));
    }

    /**
     * Approve link — sisi lawan dunia terisi, status -> active.
     */
    public function approve(string $token, Request $request): JsonResponse
    {
        $actor = $this->actors->resolve($request->user());
        $type = $actor['type'];

        if (! $type || ! $actor['entity']) {
            return response()->json(['message' => 'Akun tidak terikat ke entity customer/surveyor.'], 403);
        }

        $connection = Connection::where('token', $token)->first();
        if (! $connection) {
            return response()->json(['message' => 'Link tidak ditemukan.'], 404);
        }
        if ($connection->status !== 'pending') {
            return response()->json(['message' => 'Link sudah tidak berlaku (status: ' . $connection->status . ').'], 422);
        }

        // Dunia lawan: kalau link dibuat customer, approver wajib surveyor.
        $initiatorType = $connection->customer_id ? 'customer' : 'surveyor';
        if ($type === $initiatorType) {
            return response()->json(['message' => 'Tidak bisa approve link sendiri.'], 422);
        }

        // Entity non-aktif tidak boleh approve.
        if (! $actor['entity']->is_active) {
            return response()->json(['message' => 'Entity non-aktif tidak bisa approve.'], 422);
        }

        // Duplikat pasangan: cek connection active/pending lain utk pasangan sama.
        $pair = ['customer_id' => $connection->customer_id, 'surveyor_id' => $connection->surveyor_id];
        $pair[$type . '_id'] = $actor['entity']->id;

        $dupe = Connection::where('id', '!=', $connection->id)
            ->where('customer_id', $pair['customer_id'])
            ->where('surveyor_id', $pair['surveyor_id'])
            ->whereIn('status', ['pending', 'active'])
            ->first();
        if ($dupe) {
            return response()->json(['message' => 'Koneksi untuk pasangan ini sudah ada.'], 409);
        }

        $connection->update([
            $type . '_id'   => $actor['entity']->id,
            'status'        => 'active',
            'approved_by'   => $request->user()->id,
            'approved_at'   => now(),
        ]);

        Log::info('[Connection] approved', ['id' => $connection->id, 'by' => $type, 'entity_id' => $actor['entity']->id]);

        return response()->json($this->present($connection));
    }

    /**
     * Batalkan link pending — hanya pembuatnya.
     */
    public function cancel(int $id, Request $request): JsonResponse
    {
        $actor = $this->actors->resolve($request->user());
        if (! $actor['type'] || ! $actor['entity']) {
            return response()->json(['message' => 'Akun tidak terikat ke entity customer/surveyor.'], 403);
        }

        $connection = Connection::find($id);
        if (! $connection) {
            return response()->json(['message' => 'Connection tidak ditemukan.'], 404);
        }
        if ($connection->status !== 'pending') {
            return response()->json(['message' => 'Hanya link pending yang bisa dibatalkan.'], 422);
        }

        // hanya pembuat
        if ($connection->created_by !== $request->user()->id) {
            return response()->json(['message' => 'Hanya pembuat link yang bisa membatalkan.'], 403);
        }

        $connection->update(['status' => 'cancelled']);

        Log::info('[Connection] cancelled', ['id' => $connection->id]);

        return response()->json($this->present($connection));
    }

    /** Presentasi ringkas utk response. */
    private function present(Connection $connection): array
    {
        $connection->load(['customer:id,code,name,type,parent_id', 'surveyor:id,code,name,type,parent_id', 'creator:id,name', 'approver:id,name']);

        return [
            'id'          => $connection->id,
            'token'       => $connection->token,
            'status'      => $connection->status,
            'customer'    => $connection->customer,
            'surveyor'    => $connection->surveyor,
            'created_by'  => $connection->creator?->name,
            'approved_by' => $connection->approver?->name,
            'approved_at' => $connection->approved_at?->toIso8601String(),
            'created_at'  => $connection->created_at?->toIso8601String(),
        ];
    }
}
