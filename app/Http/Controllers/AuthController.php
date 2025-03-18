<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user(); // Get the authenticated user

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'freelancer') {
            return redirect()->route('freelancer.dashboard');
        } elseif ($user->role === 'client') {
            return redirect()->route('clients.dashboard');
        } else {
            return redirect()->route('home'); // Default route
        }
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}

}
