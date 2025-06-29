<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
//    public function __construct() {
//        $this->middleware('auth')->except(['index', 'show']);   // Another way to apply middlewares
//    }

    public function __construct()
    {           // Since this is a Resource Controller we can use the 3rd way of Authorization. Remember when using this way you have to look the Policy table in the Docs to see which Policy method goes to which Controller method
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia(
            'Listing/Index',
            [
                'listings' => Listing::orderByDesc('created_at')                 //all()
                    ->paginate(10)
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Listing::class);
        return inertia('Listing/Create');
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

        return redirect()->route('listing.Index')                  // Flash messages are part of laravel ->with()
            ->with('success', 'Listing was created successfully!!');    // Will be accessible thanks to inertia flash data
    }

    /**
     * Display the specified resource.
     */
//    public function show(string $id)      // You can use this and just pass the id through the URL
    public function show(Listing $listing)  // But this is another way to do that called Model Route Binding (Laravel will fetch the model using the given id from the route parameter)
    {
//        if (Auth::user()->cannot('view', $listing)) {   // The can/cannot methods just return a boolean value
//            abort(403);             // This stop the Controller
//        }
        $this->authorize('view', $listing);     // This line does the same as the 3 above
        return inertia(
            'Listing/Show',
            [
//                'listing' => Listing::find($id); // You can use this and just pass the id through the URL
                'listing' => $listing   // This way you dont have to find() it, because you will get the listing already
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)      // Using Model Route Binding
    {
        return inertia(
            'Listing/Edit',
            [
                'listing' => $listing   // This way you dont have to find() it, because you will get the listing already
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

        return redirect()->route('listing.Index')
            ->with('success', 'Listing was edited successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(string $id)
    public function destroy(Listing $listing)     // Using Binding model routing (most convenient way to delete models from database)
    {
        $listing->delete();
        return redirect()->back()->with('success', 'Listing was deleted!!');    // Delete method from the model
    }
}
