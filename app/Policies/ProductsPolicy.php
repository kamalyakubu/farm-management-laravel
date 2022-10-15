<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Products;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the products can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list allproducts');
    }

    /**
     * Determine whether the products can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Products  $model
     * @return mixed
     */
    public function view(User $user, Products $model)
    {
        return $user->hasPermissionTo('view allproducts');
    }

    /**
     * Determine whether the products can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create allproducts');
    }

    /**
     * Determine whether the products can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Products  $model
     * @return mixed
     */
    public function update(User $user, Products $model)
    {
        return $user->hasPermissionTo('update allproducts');
    }

    /**
     * Determine whether the products can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Products  $model
     * @return mixed
     */
    public function delete(User $user, Products $model)
    {
        return $user->hasPermissionTo('delete allproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Products  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete allproducts');
    }

    /**
     * Determine whether the products can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Products  $model
     * @return mixed
     */
    public function restore(User $user, Products $model)
    {
        return false;
    }

    /**
     * Determine whether the products can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Products  $model
     * @return mixed
     */
    public function forceDelete(User $user, Products $model)
    {
        return false;
    }
}
