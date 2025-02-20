<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->sort ?? 10;
        $search = $request->search ?? null;

        $subscription = Subscription::withCount('subscribtionUser')
                                    ->when($search, function ($query, $search) {
                                        return $query->where('title', 'like', "%$search%");
                                    })
                                    ->orderBy('id', 'DESC')
                                    ->paginate($sort);
        
        return view("pages.admin.subscription.index", compact("subscription"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.admin.subscription.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "limit" => "required|numeric"
        ]);

        $post = $request->all();
        $post['slug'] = Str::slug($request->title);

        Subscription::create($post);

        return redirect()->route('subscription.index')->with('success', 'Successfully Aded Subscribtion');
    }

    /**
     * Show the form the specified resource.
     */
    public function show(string $slug, Request $request)
    {
        $search = $request->search ?? null;

        $subscription = Subscription::where('slug', $slug)->first();

        $user = User::role("User")
                    ->whereDoesntHave('subscriptions', function ($query) use ($subscription) {
                        $query->where('subscriptions_id', $subscription->id);
                    })
                    ->when($search, function ($query, $search) {
                        return $query->where('name', 'like', "%$search%")
                                    ->orWhere('email', 'like', "%$search%");
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate(5);

        $subscriptionUser = SubscriptionUser::with('user')
                                    ->where('subscriptions_id', $subscription->id)
                                    ->orderBy('id', 'DESC')
                                    ->paginate(5);

        return view("pages.admin.subscription.show", compact('subscription', 'user', 'subscriptionUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subscription = Subscription::find($id);
        return view("pages.admin.subscription.edit", compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "title" => "required|string",
            "limit" => "required|numeric"
        ]);

        $subscription = Subscription::find($id);

        $put = $request->all();
        $put['slug'] = Str::slug($request->title);

        $subscription->update($put);

        return redirect()->route('subscription.index')->with('success', 'Successfully Updated Subscribtion');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['code' => 400, 'status' => 'erorr', 'message' => 'Subscribtion Not Found !']);
        }

        $subscription->delete();

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfully Deleted Subscribtion !']);
    }

    public function bulkInsert(Request $request) 
    {
        $request->validate([
            "users_id" => "required"
        ], [
            "users_id.required" => "Select the user you want to register for subscription!"
        ]);
    
        foreach ($request->users_id as $key => $value) {
            SubscriptionUser::create([
                "users_id" => $value,
                "limit" => $request->limit,
                "subscriptions_id" => $request->subscriptions_id
            ]);
        }

        return back()->with('success', 'Successfuly Aded User To Subscribtion.');
    }

    public function removeSubscribtion($subscription_id) 
    {
        $subscriptionUsers = SubscriptionUser::where('id', $subscription_id)->first();    
        
        if (!$subscriptionUsers) {
            return response()->json(['code' => 400, 'status' => 'erorr', 'message' => 'Subscribtion User Not Found !']);
        }

        $subscriptionUsers->delete();

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfully Removed User !']);
    }
}
