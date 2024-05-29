<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\DrugCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DrugCategoryPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::ADMIN->value) || $user->hasRole(RoleEnum::PHARMACIST->value)) {
            return true;
        }

        return null; // see the note above in Gate::before about why null must be returned here.
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_drug_category');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DrugCategory $drugCategory): bool
    {
        return $user->hasPermission('view_drug_category');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_drug_category');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DrugCategory $drugCategory): bool
    {
        return $user->hasPermission('update_drug_category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermission('delete_any_drug_category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DrugCategory $drugCategory): bool
    {
        return $user->hasPermission('delete_drug_category');
    }
}
