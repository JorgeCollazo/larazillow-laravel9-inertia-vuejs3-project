<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    public function index()
    {
//        $listing = (Listing::find(10));
//        $listing->city="Springfield";
//        $listing->save();
//        dd($listing);
        return inertia(
    'Index/Index',
              [
                  'message' => 'Hello from Laravel!'
              ]
        );
    }
    public function show()
    {
        return inertia('Index/Show');
    }
}
