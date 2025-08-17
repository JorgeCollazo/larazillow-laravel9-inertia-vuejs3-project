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
    {   // Since this is a Resource Controller we can use the 3rd way of Authorization. Remember when using this way you have to look the Policy table in the Docs to see which Policy method goes to which Controller method, you need to stick to conventions in order to work as is expected
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)     // After all code move to the Model the controller looks much simpler
    {
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);

//        $query = Listing::orderByDesc('created_at');      // all()
                                                            // orderByDesc() was moved to the scope method in the Model
        $query = Listing::mostRecent();    // This another way (cleaner) concatenating the queries, each method will return a new Query Builder instance
// This was moved to the scope function
//            ->when(
//                $filters['priceFrom'] ?? false,         // This condition should be met in order to get the fn executed
//                fn($query, $value) => $query->where('price', '>=', $value)
//            )
//            ->when(
//                $filters['priceTo'] ?? false,         // This condition should be met in order to get the fn executed
//                fn($query, $value) => $query->where('price', '<=', $value)
//            )
//            ->when(
//                $filters['beds'] ?? false,         // This condition should be met in order to get the fn executed
//                fn($query, $value) => $query->where('beds', (int)$value < 6 ? '=' : '>=', $value)
//            )
//            ->when(
//                $filters['baths'] ?? false,         // This condition should be met in order to get the fn executed
//                fn($query, $value) => $query->where('baths', (int)$value < 6 ? '=' : '>=', $value)
//            )
//            ->when(
//                $filters['areaFrom'] ?? false,         // This condition should be met in order to get the fn executed
//                fn($query, $value) => $query->where('area', '>=', $value)
//            )
//            ->when(
//                $filters['areaTo'] ?? false,         // This condition should be met in order to get the fn executed
//                fn($query, $value) => $query->where('area', '>=', $value)
//            );

        // This is the same as below using the Query builder as well but the method when()

//        $query->when(
//            $filters['priceFrom'] ?? false,         // This condition should be met in order to get the fn executed
//            fn($query, $value) => $query->where('price', '>=', $value)
//        );

        // Using conditionals

/*        if ($filters['priceFrom'] ?? false) {
            $query->where('price', '>=', $filters['priceFrom']);
        }

        if ($filters['priceTo'] ?? false) {
            $query->where('price', '<=', $filters['priceTo']);
        }

        if ($filters['beds'] ?? false) {
            $query->where('beds', $filters['beds']);
        }

        if ($filters['baths'] ?? false) {
            $query->where('baths', $filters['baths']);
        }

        if ($filters['areaFrom'] ?? false) {
            $query->where('area', '>=', $filters['areaFrom']);
        }

        if ($filters['areaTo'] ?? false) {
            $query->where('area', '<=', $filters['areaTo']);
        }*/

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => $query        // You can get rid of this variable and place all code directly here OR write 'listings' => Listing::mostRecent()->paginate(10)->withQueryString();
                    ->filter($filters)       // This will apply the filter method from the Model with all moved logic
                    ->paginate(10)
                    ->withQueryString()     // This will keep the query string in the URL when paginating just concatenating the page parameter
            ]
        );
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
     * Remove the specified resource from storage.
     */
//    public function destroy(string $id)           //    Was removed


//    public function destroy(Listing $listing)     // Using Binding model routing (most convenient way to delete models from database)
//    {
//        $listing->delete();
//        return redirect()->back()->with('success', 'Listing was deleted!!');    // Delete method from the model
//    }
}
