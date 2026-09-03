<?php

declare(strict_types=1);

namespace Modules\Connection\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Models\Customer;
use Modules\Surveyor\Models\Surveyor;

/**
 * Resolve entity "aktif" dari user yang login.
 *
 * Aturan bisnis: user = admin dari entity (customers.admin_id /
 * surveyors.admin_id). Branch adalah row di tabel customers/surveyors
 * dengan type='branch', jadi cukup lookup by admin_id — otomatis
 * mencakup HO maupun branch.
 *
 * return array{type: 'customer'|'surveyor'|null, entity: Model|null}
 */
class ActorResolver
{
    /**
     * @return array{type: string|null, entity: Model|null}
     */
    public function resolve(?User $user): array
    {
        if (! $user) {
            return ['type' => null, 'entity' => null];
        }

        $customer = Customer::where('admin_id', $user->id)->first();
        if ($customer) {
            return ['type' => 'customer', 'entity' => $customer];
        }

        $surveyor = Surveyor::where('admin_id', $user->id)->first();
        if ($surveyor) {
            return ['type' => 'surveyor', 'entity' => $surveyor];
        }

        return ['type' => null, 'entity' => null];
    }
}
