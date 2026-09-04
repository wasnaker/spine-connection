<?php

declare(strict_types=1);

namespace Modules\Connection\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Modules\Connection\Models\Connection;
use Modules\Customer\Models\Customer;
use Modules\Surveyor\Models\Surveyor;

/**
 * ConnectionDemoSeeder — snapshot data demo connections (wasnaker.lan).
 *
 * Data (22 baris: 16 active, 4 pending, 2 cancelled) diambil dari DB staging
 * (2026-09-04), disimpan sebagai JSON di data/connections-demo.json. Record
 * direferensikan via CODE entity + email admin (bukan id) supaya idempotent
 * dan aman dijalankan di env mana pun setelah seeder Customer & Surveyor.
 */
class ConnectionDemoSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->loadData() as $row) {
            // Resolve entity via email admin (UNIK) — code bisa duplikat per parent.
            $customer = $row['customer_admin']
                ? Customer::whereHas('admin', fn ($q) => $q->where('email', $row['customer_admin']))->first()
                : null;
            $surveyor = $row['surveyor_admin']
                ? Surveyor::whereHas('admin', fn ($q) => $q->where('email', $row['surveyor_admin']))->first()
                : null;
            if (! $customer || ! $surveyor) {
                $this->command?->warn(sprintf(
                    '[Connection] skip %s <-> %s: entity/admin belum ada.',
                    $row['customer_admin'] ?? '?', $row['surveyor_admin'] ?? '?'
                ));
                continue;
            }

            $creator  = $row['created_by']  ? User::where('email', $row['created_by'])->first()  : null;
            $approver = $row['approved_by'] ? User::where('email', $row['approved_by'])->first() : null;

            $conn = Connection::firstOrCreate(
                [
                    'customer_id' => $customer->id,
                    'surveyor_id' => $surveyor->id,
                    'status'      => $row['status'],
                ],
                ['token' => Str::random(48)]
            );

            $conn->update([
                'status'      => $row['status'],
                'created_by'  => $creator?->id,
                'approved_by' => $approver?->id,
                'approved_at' => $row['approved_at'] ?: null,
            ]);
        }

        $this->command?->info(sprintf(
            'Demo connections siap: %d total (active: %d).',
            Connection::count(),
            Connection::where('status', 'active')->count()
        ));
    }

    private function loadData(): array
    {
        $file = __DIR__ . '/data/connections-demo.json';
        if (! is_file($file)) {
            throw new \RuntimeException("Snapshot tidak ditemukan: {$file}");
        }

        return json_decode((string) file_get_contents($file), true, flags: JSON_THROW_ON_ERROR);
    }
}
