<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormCompleted;
use App\Models\FormCompletedSection;
use App\Models\Message;
use App\Models\WatsaapMaticKey;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

class FormPublicController extends Controller
{
    protected $client;
    protected $url;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = "https://app.wasapmatic.com/api/send/whatsapp";
    }

    public function index($slug_user, $slug_form)
    {
        $form = Form::with('section')
                    ->where('slug', $slug_form)
                    ->where('status', 'publish')
                    ->first();

        if (!$form) {
            return abort(404);
        }

        return view("pages.public.form", compact("form"));     
    }

    public function priview($slug_user, $slug_form)
    {
        $form = Form::with('section')
                    ->where('slug', $slug_form)
                    ->first();

        if (!$form) {
            return abort(404);
        }

        return view("pages.public.priview", compact("form"));     
    }

    public function submit(Request $request)
    {
        $request->validate([
            "username" => "required",
            "email" => "required",
            "phone" => "required"
        ]);  

        $autoMessage = Message::where('users_id', Auth::user()->id)->where('status', 1)->latest()->first();
        $apikey = WatsaapMaticKey::where('users_id', $request->users_id)->first();

        if (!$apikey || !$autoMessage) {
            return response()->json([
                'error' => true,
                'message' => 'API Key or Auto Message not found.'
            ], 400);
        }

        $data = [
            "secret" => $apikey->api_secret,
            "account" => $apikey->unique_wa_id,
            "recipient" => $request->phone,
            "type" => "text",
            "message" => $autoMessage->body
        ];

        try {
            $response = $this->client->post($this->url, [
                'form_params' => $data
            ]);

            $formCompleted = FormCompleted::create([
                'forms_id' => $request->forms_id,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if (!empty($request->section_form)) {
                foreach ($request->section_form as $key => $value) {
                    $formSection = new FormCompletedSection();
                    $formSection->form_completed_id = $formCompleted->id;
                    $formSection->sections_id = $request->sections_id[$key];
                    $formSection->type = $request->type[$key];

                    if ($request->type[$key] == "text") {
                        $formSection->section_text = $value;
                    }

                    if ($request->type[$key] == "number") {
                        $formSection->section_number = $value;
                    }

                    if ($request->type[$key] == "email") {
                        $formSection->section_email = $value;
                    }

                    if ($request->type[$key] == "date") {
                        $formSection->section_date = $value;
                    }

                    $formSection->save();
                }
            }
            
            return back()->with('success', 'Successfully filled in the form');
        } catch (RequestException $e) {
            return back()->with('error', $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage());
        }
    }
}