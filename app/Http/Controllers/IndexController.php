<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    public function index()
    {
//        dd(Auth::check());
//        $listing = (Listing::find(10));
//        $listing->city="Springfield";
//        $listing->save();
//        dd(Auth::user());
        return inertia( // relative path to resources/js/pages'
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
