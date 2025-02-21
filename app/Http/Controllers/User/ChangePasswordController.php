<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index() 
    {
        return view("pages.user.change-password.index");     
    }

    public function update(Request $request, string $id) 
    {
        $request->validate([
            "password_old" => "required|string",
            "password" => "required|min:8|confirmed",
            "password_confirmation" => "required"
        ]);  

        $user = User::find($id);

        $post = $request->except('password_old', 'password_confirmation');
        $post['password'] = Hash::make($request->password);

        if (!Hash::check($request->password_old, $user->password)) {
            return back()->with(["error" => "Old Password Is Inappropriate!"]);
        }
        
        $user->update($post);

        return back()->with('success', 'Successfully changed password');
    }
}
