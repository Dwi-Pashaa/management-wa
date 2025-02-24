<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort   = $request->sort ?? 10;
        $search = $request->search ?? null;

        $users = User::role('User')
                        ->when($search, function ($query, $search) {
                            return $query->where('name', 'like', "%$search%")
                                        ->orWhere('email', 'like', "%$search%");
                        })
                        ->orderBy('id', 'DESC')
                        ->paginate($sort);

        return view("pages.admin.users.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|unique:users,email",
            "password" => "required|min:8|confirmed",
            "password_confirmation" => "required|min:8"
        ]);

        $post = $request->except("password_confirmation");
        $post['slug'] = Str::slug($request->name);

        $user = User::create($post);
        $user->assignRole("User");

        return redirect()->route('users.index')->with('success', 'Successfully Aded Users');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::find($id);
        return view("pages.admin.users.edit", compact("users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|string",
            "email" => [
                "required",
                Rule::unique('users', 'email')->ignore($id),
            ],
        ]);

        $user = User::find($id);

        $put = $request->all();
        $put['slug'] = Str::slug($request->name);

        $user->update($put);

        return redirect()->route('users.index')->with('success', 'Successfully Edited Users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'User Not Found.']);
        }

        $user->delete();

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfuly deleted this data.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function forgot(string $id)
    {
        $users = User::find($id);
        return view("pages.admin.users.forgot", compact("users"));
    }

    public function change(Request $request, string $id) 
    {
        $request->validate([
            "password" => "required|min:8|confirmed",
            "password_confirmation" => "required"
        ]);  

        $user = User::find($id);

        $post = $request->except('password_old', 'password_confirmation');
        $post['password'] = Hash::make($request->password);

        $user->update($post);

        return redirect()->route('users.index')->with('success', 'Successfully changed password');
    }
}
