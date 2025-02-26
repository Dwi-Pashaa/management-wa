<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormPublicController extends Controller
{
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
}
