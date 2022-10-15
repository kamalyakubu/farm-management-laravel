<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subcategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubcategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the subcategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list subcategories');
    }

    /**
     * Determine whether the subcategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subcategory  $model
     * @return mixed
     */
    public function view(User $user, Subcategory $model)
    {
        return $user->hasPermissionTo('view subcategories');
    }

    /**
     * Determine whether the subcategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create subcategories');
    }

    /**
     * Determine whether the subcategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subcategory  $model
     * @return mixed
     */
    public function update(User $user, Subcategory $model)
    {
        return $user->hasPermissionTo('update subcategories');
    }

    /**
     * Determine whether the subcategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subcategory  $model
     * @return mixed
     */
    public function delete(User $user, Subcategory $model)
    {
        return $user->hasPermissionTo('delete subcategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subcategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete subcategories');
    }

    /**
     * Determine whether the subcategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subcategory  $model
     * @return mixed
     */
    public function restore(User $user, Subcategory $model)
    {
        return false;
    }

    /**
     * Determine whether the subcategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subcategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, Subcategory $model)
    {
        return false;
    }
}
