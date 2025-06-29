<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
//    public function before(?User $user, $ability)   // $ability is the name of the specific method below, this method wil allow us to overwrite the rest of policies, it will allow you to edit a listing that wasn't created by you but not delete it, the method is called "before" because it runs before all others methods in the class
//    {
////        return isset($user->is_admin);
////        return ($user?->is_admin ?? false) && ($ability === 'update' || $ability === 'viewAny'); //Same as above
//          return true;
//    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool          // The ? mark here is making the parameter optional (nullable)
    {
        return true;    // This is to see the list of listings
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listing $listing): bool  // This is to see a specific list
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;  // To assure that only the people who created the listing are the ones that can edit it
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }
}
