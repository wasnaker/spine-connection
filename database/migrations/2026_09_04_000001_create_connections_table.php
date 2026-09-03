<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel connections — relasi many-to-many customer <-> surveyor.
 *
 * Alur invite link:
 *   - Siapa pun (customer-world atau surveyor-world) membuat link via
 *     POST /api/v1/connections -> row pending dengan token unik.
 *   - Sisi pengirim terisi (customer_id ATAU surveyor_id) + created_by.
 *   - Penerima (dunia lawan) buka link & approve -> sisi lawan terisi,
 *     approved_by + approved_at di-set, status = active.
 *
 * Constraint unik di level aplikasi: (customer_id, surveyor_id) hanya boleh
 * ada SATU connection active/pending — generate ulang untuk pasangan sama
 * ditolak 409.
 *
 * Lifecycle: status (pending|active|cancelled), soft deletes, ulid.
 * Created by / approved by = users.id (admin entity yang bertindak).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ulid', 26)->nullable()->unique();
            $table->string('token', 64)->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('surveyor_id')->nullable()->constrained('surveyors')->cascadeOnDelete();
            $table->string('status', 16)->default('pending'); // pending|active|cancelled
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'surveyor_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
