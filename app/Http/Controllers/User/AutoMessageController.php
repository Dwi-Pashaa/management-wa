<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? null;

        $autoMessage = Message::where('users_id', Auth::user()->id)
                                ->when($search, function ($query, $search) {
                                    return $query->where('title', 'like', "%$search%");
                                })
                                ->orderBy('id', 'DESC')
                                ->paginate(10);

        return view("pages.user.auto-messages.index", compact("autoMessage"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.user.auto-messages.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "body" => "required"
        ]);

        $post = $request->all();
        $post['users_id'] = Auth::user()->id;

        Message::create($post);

        return redirect()->route('auto.message.index')->with('success', 'Successfully Created Auto Message!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $autoMessage = Message::find($id);
        return view("pages.user.auto-messages.edit", compact("autoMessage"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "title" => "required",
            "body" => "required"
        ]);

        $autoMessage = Message::find($id);

        $put = $request->all();
        $autoMessage->update($put);

        return redirect()->route('auto.message.index')->with('success', 'Successfully Updated Auto Message!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $autoMessage = Message::find($id);

        if (!$autoMessage) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'Auto Message Not Found !']);
        }

        $autoMessage->delete();

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfully Deleted Auto Message !']);
    }
}
