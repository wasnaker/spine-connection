<?php

declare(strict_types=1);

namespace Modules\Connection\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Customer\Models\Customer;
use Modules\Surveyor\Models\Surveyor;

/**
 * Connection — relasi many-to-many customer <-> surveyor.
 *
 * Row dibuat via invite link:
 *   - pending: satu sisi terisi (customer_id ATAU surveyor_id).
 *   - active:  kedua sisi terisi (customer_id DAN surveyor_id) + approved_by.
 *   - cancelled: dibatalkan.
 *
 * Relasi dibuat via ulid di sisi model (HasUlids), id = auto increment.
 */
class Connection extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $table = 'connections';

    protected $fillable = [
        'token',
        'customer_id',
        'surveyor_id',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'status'      => 'string',
        'approved_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function surveyor(): BelongsTo
    {
        return $this->belongsTo(Surveyor::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
