<?php

declare(strict_types=1);

namespace App\Policies\Seo;

use App\Models\Seo\SeoTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SeoTemplatePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SeoTemplate');
    }

    public function view(AuthUser $authUser, SeoTemplate $seoTemplate): bool
    {
        return $authUser->can('View:SeoTemplate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SeoTemplate');
    }

    public function update(AuthUser $authUser, SeoTemplate $seoTemplate): bool
    {
        return $authUser->can('Update:SeoTemplate');
    }

    public function delete(AuthUser $authUser, SeoTemplate $seoTemplate): bool
    {
        return $authUser->can('Delete:SeoTemplate');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:SeoTemplate');
    }

    public function restore(AuthUser $authUser, SeoTemplate $seoTemplate): bool
    {
        return $authUser->can('Restore:SeoTemplate');
    }

    public function forceDelete(AuthUser $authUser, SeoTemplate $seoTemplate): bool
    {
        return $authUser->can('ForceDelete:SeoTemplate');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SeoTemplate');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SeoTemplate');
    }

    public function replicate(AuthUser $authUser, SeoTemplate $seoTemplate): bool
    {
        return $authUser->can('Replicate:SeoTemplate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SeoTemplate');
    }
}
