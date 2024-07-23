<?php

namespace App\Policies;

use App\Models\LetterActionDepartment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LetterActionDepartmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LetterActionDepartment $letterActionDepartment): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LetterActionDepartment $letterActionDepartment): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LetterActionDepartment $letterActionDepartment): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LetterActionDepartment $letterActionDepartment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LetterActionDepartment $letterActionDepartment): bool
    {
        //
    }
}
