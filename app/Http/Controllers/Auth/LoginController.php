<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index() 
    {
        return view("auth.login");    
    }

    public function login(Request $request) 
    {
        $request->validate([
            "email" => "required|exists:users,email",
            "password" => "required"
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect()->route('dashboard');
            } else {
                return back()->with('error', 'Email/Password Incorect.');
            }
        }

        return back()->with('error', 'Account Not Registered.');
    }

    public function logout() 
    {
        Auth::logout();
        Session::flush();
        
        return redirect()->route('login');
    }
}
