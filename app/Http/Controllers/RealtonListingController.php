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
    public function index(Request $request) // To access the user you can use the Request $request->user() method, or Auth::user() if you want to use the Auth facade
    { //dd($request->boolean('deleted')); // You can cast the value to boolean directly this way
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ... $request->only(['by', 'order'])         // This three dot operator is called the spread operator, it will merge the array with the existing one
        ];

        return inertia(
            'Realtor/Index',
            [   'filters' => $filters, // This will be passed to the Index.vue component as a prop
                'listings' => Auth::user()
                ->listings()
//                ->mostRecent() // This is a scope method defined in the Listing model, it will order the listings by created_at in descending order
                ->filter($filters)
                ->paginate(5) // This will paginate the results, you can change the number of items per page
                ->withQueryString() // This will keep the query string in the URL when paginating, so you can keep the filters applied
//                ->get()
            ]
//            ['listings' => Auth::user()->listings]    // Simplest way
        ); // You might be tempting to do this (and you could) 'listings' => Listing::where('')] but lets use a Facade
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $this->authorize('create', Listing::class);
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());              // $request parameter will contain all submitted data
//        $listing = new Listing();         // You can use this way but you can also use the create model method (fillable)
//        $listing->beds = $request->beds;
//        $listing->save();

//        Listing::create($request->all());     // This will pass all the data but without checking it, which is not safe, this is good just for testing faster if the insert functionality is working
//        Listing::create([
//            ...$request->all(),             // ... operator allows you to merge multiple arrays together (like array_merge in php)
//            ...$request->validate([         // This will replace all the keys on all() array by those who are in the validate array (intersection)
//                'beds' => 'required|integer|min:0|max:20'    // You can check for all validation constraints in laravel docs (validation rules)
//            ])                                               // the resulting errors will be returned by HandleInertiaRequests middleware (parent::share($request))
//        ]);
//           Listing::create(                               // Replaced with below statement because it'll associate the listing with the user as well
        $request->user()->listings()->create(
            $request->validate([         // This other way will just pass the data that passes validation
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );

        return redirect()->route('realtor.listing.Index')                  // Flash messages are part of laravel ->with()
        ->with('success', 'Listing was created successfully!!');    // Will be accessible thanks to inertia flash data
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
    public function edit(Listing $realton_listing)      // Using Model Route Binding
    {
        return inertia(
            'Realtor/Edit',
            [
                'listing' => $realton_listing   // This way you dont have to find() it, because you will get the listing already
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)  // Using Model Binding
    {
        $listing->update(                                       // Using Model Binding Before we were using Listing::create([]) static method
            $request->validate([         // This other way will just pass the data that passes validation
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );

        return redirect()->route('realtor.listing.Index')
            ->with('success', 'Listing was edited successfully!!');
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

    public function restore(Listing $realton_listing) {
        $realton_listing->restore(); // This will restore a soft deleted listing
        return redirect()->back()->with('success', 'Listing restored successfully.');
    }
}
