<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request)
    {
        $user = User::create($request->validate([         // make and create methods are use when you want to use mass assignment
            'name' => 'required',
            'email' => 'required|email|unique:users',   //  This last field validates that there is no other record like that in the table users
            'password' => 'required|min:8|confirmed'    // This is why we need a password confirmation field in the form later
        ]));

//        $user->password = Hash::make($user->password);  // To encrypt, moved to the model, using mutators and accessors
//        $user->save();                                // In order to use create mass assignment method
        Auth::login($user);                             // This will authenticate the user manually

        return redirect()->route('listing.Index')->with('success', 'Account created!');
    }
}
