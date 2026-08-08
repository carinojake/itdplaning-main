<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;

class ContractPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('user');
    }

    public function view(User $user, Contract $contract): bool
    {
        return (int) $contract->owner_user_id === (int) $user->getKey();
    }

    public function create(User $user): bool
    {
        return $user->hasRole('user');
    }

    public function update(User $user, Contract $contract): bool
    {
        return (int) $contract->owner_user_id === (int) $user->getKey();
    }

    public function delete(User $user, Contract $contract): bool
    {
        return (int) $contract->owner_user_id === (int) $user->getKey();
    }
}
