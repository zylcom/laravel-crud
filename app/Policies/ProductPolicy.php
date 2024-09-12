<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\UserRole;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAll(User $user): Response
    {
        if ($user->role === UserRole::Admin) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized');
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): Response
    {
        if ($user->role === UserRole::Admin) {
            return Response::allow();
        } elseif ($user->id === $product->user_id) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized');
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role === UserRole::Admin || $user->role === UserRole::User) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized');
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): Response
    {
        if ($user->role === UserRole::Admin) {
            return Response::allow();
        } elseif ($user->id === $product->user_id) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized');
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): Response
    {
        if ($user->role === UserRole::Admin) {
            return Response::allow();
        } elseif ($user->id === $product->user_id) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized');
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        //
    }
}
