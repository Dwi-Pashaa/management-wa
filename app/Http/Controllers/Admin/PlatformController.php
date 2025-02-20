<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index() 
    {
        $platforms = Platform::first();
        return view("pages.admin.platform.index", compact("platforms"));    
    }

    public function save(Request $request) 
    {
        $request->validate([
            "name" => "required|string",
            "logo" => "required|mimes:png,jpg,jpeg"
        ]);   

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = rand() . '.' . $file->getClientOriginalExtension();
            $directory = 'platform-logo/';
            $file->move($directory, $fileName);

            $logoPath = $directory . $fileName;
        } else {
            $logoPath = null;
        }

        Platform::updateOrCreate(
            ['name' => $request->name],
            ['logo' => $logoPath]
        );

        return back()->with('success', 'Platform Setting Saved.');
    }
}
