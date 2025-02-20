<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WatsaapMaticKey;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SetApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? null;

        $apikey = WatsaapMaticKey::where('users_id', Auth::user()->id)
                    ->when($search, function ($query, $search) {
                        return $query->where('name', 'like', "%$search%");
                    })
                    ->latest()
                    ->first();

        $device = [];
        $deviceCount = 0;

        if ($apikey != null) {
            $url = "https://app.wasapmatic.com/api/get/wa.accounts";
            $params = [
                'secret' => $apikey->api_secret,
                'limit' => 10,
                'page' => 1,
            ];
        
            try {
                $response = Http::get($url, $params);
                
                if ($response->successful()) {
                    $device = $response->json();
                    $deviceCount = count($device['data']);
                }
            } catch (\Exception $e) {
                $device = ['error' => $e->getMessage()];
            }
        }

        return view("pages.user.set-apikey.index", compact("apikey", "device", "deviceCount"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.user.set-apikey.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "api_secret" => "required",
            "whatsapp_server_id" => "required"
        ]);

        $post = $request->all();
        $post['users_id'] = Auth::user()->id;

        WatsaapMaticKey::create($post);

        return redirect()->route('apikey.index')->with('success', 'Successfully Added Watssapmatic Secret Key.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apikey = WatsaapMaticKey::find($id);

        $url = "https://app.wasapmatic.com/api/create/wa.link";
        $apiSecret = $apikey->api_secret;
        $serverId = $apikey->whatsapp_server_id;

        $data = [];

        try {
            $response = Http::get($url, [
                'secret' => $apiSecret,
                'sid' => $serverId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
            }
        } catch (Exception $e) {
            $data = ["error" => $e->getMessage()];
        }

        return view("pages.user.set-apikey.connect", compact("data", "apikey"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $apikey = WatsaapMaticKey::find($id);
        return view("pages.user.set-apikey.edit", compact("apikey"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required",
            "api_secret" => "required",
            "whatsapp_server_id" => "required"
        ]);

        $apikey = WatsaapMaticKey::find($id);

        $put = $request->all();

        $apikey->update($put);

        return redirect()->route('apikey.index')->with('success', 'Successfully Updated Watssapmatic Secret Key.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apikey = WatsaapMaticKey::find($id);

        if (!$apikey) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'Apikey Not Found!']);
        }

        $apikey->delete();

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfully Deleted ApiKey']);
    }

    public function relink(string $id, string $unique) 
    {
        $apikey = WatsaapMaticKey::find($id);

        $data = [];

        $url = "https://app.wasapmatic.com/api/create/wa.relink";
        $params = [
            "secret" => $apikey->api_secret,
            "sid" => $apikey->whatsapp_server_id,
            "unique" => $unique
        ];

        try {
            $response = Http::get($url, $params);

            if ($response->successful()) {
                $data = $response->json();
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }

        return view("pages.user.set-apikey.relink", compact("data", "apikey"));
    }
}
