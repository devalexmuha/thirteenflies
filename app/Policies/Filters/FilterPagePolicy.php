<?php

declare(strict_types=1);

namespace App\Policies\Filters;

use App\Models\Filters\FilterPage;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class FilterPagePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FilterPage');
    }

    public function view(AuthUser $authUser, FilterPage $filterPage): bool
    {
        return $authUser->can('View:FilterPage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FilterPage');
    }

    public function update(AuthUser $authUser, FilterPage $filterPage): bool
    {
        return $authUser->can('Update:FilterPage');
    }

    public function delete(AuthUser $authUser, FilterPage $filterPage): bool
    {
        return $authUser->can('Delete:FilterPage');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:FilterPage');
    }

    public function restore(AuthUser $authUser, FilterPage $filterPage): bool
    {
        return $authUser->can('Restore:FilterPage');
    }

    public function forceDelete(AuthUser $authUser, FilterPage $filterPage): bool
    {
        return $authUser->can('ForceDelete:FilterPage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FilterPage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FilterPage');
    }

    public function replicate(AuthUser $authUser, FilterPage $filterPage): bool
    {
        return $authUser->can('Replicate:FilterPage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FilterPage');
    }
}
