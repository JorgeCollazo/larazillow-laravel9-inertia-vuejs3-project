<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create() {                    // Thinking these methods as User Session
        return inertia('Auth/Login');
    }

    public function store(Request $request)
    {   /* This method checks if there is a user with that email, the password param is required but not the email, you can put whatever you want, it just need to be present in the database */
        if (!Auth::attempt($request->validate(['email' => 'required|string|email','password' =>'required|string']), true)) { // True, to always remember the session and not logout
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'          // This is our custom validation (wrong credentials)
            ]);
        }

        $request->session()->regenerate();      // To regenerate the session for security reasons

//        return redirect()->intended();  // When a user tries to access a protected route (e.g., /dashboard) but gets redirected to a login page first, Laravel stores their original URL (e.g., /dashboard) in the session.
                                        // After login, redirect()->intended() sends them back to that stored URL.
        return redirect()->intended('/listing');    // To be redirected to that route
    }

    public function destroy() {

    }
}
