<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtonListingController extends Controller
{
    public function __construct()
    {
        // Since this is a Resource Controller we can use the 3rd way of Authorization. Remember when using this way you have to look the Policy table in the Docs to see which Policy method goes to which Controller method, you need to stick to conventions in order to work as is expected
        $this->authorizeResource(Listing::class, 'realton_listing'); // This will map the Listing model to the realton_listing route parameter
    }

    /**
     * Display a listing of the resource.
     */
    public function index() // To access the user you can use the Request $request->user() method, or Auth::user() if you want to use the Auth facade
    {
        return inertia(
            'Realtor/Index',
            ['listings' => Auth::user()->listings]
        ); // You might be tempting to do this (and you could) 'listings' => Listing::where('')] but lets use a Facade
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $realton_listing)       // This name must match the exact name of the route parameter that is being passed or use the ->parameters(['realton-listing' => 'listing']); to map URL parameter to method parameter
    {
        try {
            // Add debug output
            \Log::info('Attempting to delete listing', ['id' => $realton_listing->id]);

            $deleted = $realton_listing->deleteOrFail();

            \Log::info('Delete result', ['success' => $deleted]);

            if (!$deleted) {
                throw new \Exception('Delete operation returned false');
            }

            return redirect()->back()->with('success', 'Listing deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Delete failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete listing');
        }

//        $listing->delete(); // This will soft delete the listing, if you want to hard delete it use forceDelete() method
//        $listing->deleteOrFail(); // This will throw an exception if the delete fails, useful for debugging
//        return redirect()->back()->with('success', 'Listing deleted successfully.');
    }
}
