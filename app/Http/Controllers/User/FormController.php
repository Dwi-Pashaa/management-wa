<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Section;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        $sort = $request->sort ?? null;

        $forms = Form::with('user')
                    ->where('users_id', Auth::user()->id)
                    ->when($search, function ($query, $search) {
                        return $query->where('title', 'like', "%$search%");
                    })
                    ->paginate($sort);
        return view("pages.user.form.index", compact("forms"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscribtion = Subscription::select(['title', 'id'])->get();
        return view("pages.user.form.create", compact("subscribtion"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "subscriptions_id" => "required"
        ]);

        $post = $request->all();
        $post['slug'] = Str::slug($request->title);
        $post['users_id'] = Auth::user()->id;

        Form::create($post);

        return back()->with('success', 'Successfully Created Form.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $slug)
    {
        $forms = Form::with('user', 'section')
                    ->where('id', $id)
                    ->where('slug', $slug)
                    ->first();

        // $section = Section::where('forms_id', $forms->id)->get();

        return view("pages.user.form.show", compact("forms"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $forms = Form::find($id);

        if (!$forms) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'Failed Deleted Form.']);
        }

        $forms->delete();

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfully Deleted Form.']);
    }

    public function bulkInsertForm(Request $request) 
    {
        $forms = Form::where('id', $request->forms_id)->first();

        $rules = [
            "desc" => "required",
            "name" => "required|array",
            "name.*" => "required",
            "type" => "required|array",
            "type.*" => "required",
            "is_required" => "required|array",
            "is_required.*" => "required"
        ];

        if ((!$forms || !$forms->thumbnail) && $request->hasFile('thumbnail')) {
            $rules['thumbnail'] = "sometimes|file";
        }

        if ((!$forms || !$forms->header) && $request->hasFile('header')) {
            $rules['header'] = "sometimes|file";
        }

        $request->validate($rules);

        $headerSave = $forms->header ?? null;
        if ($request->hasFile('header')) {
            $header = $request->file('header');
            $headerName = rand() . '.' . $header->getClientOriginalExtension();
            $pathHeader = 'header/';
            $header->move($pathHeader, $headerName);
            $headerSave = $pathHeader . $headerName;
        }

        $thumbnailSave = $forms->thumbnail ?? null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = rand() . '.' . $thumbnail->getClientOriginalExtension();
            $pathThumbnail = 'thumbnail/';
            $thumbnail->move($pathThumbnail, $thumbnailName);
            $thumbnailSave = $pathThumbnail . $thumbnailName;
        }

        $forms->update([
            "title" => $request->title,
            "slug" => Str::slug($request->title),
            "header" => $headerSave,
            "thumbnail" => $thumbnailSave,
            "desc" => $request->desc
        ]);

        foreach ($request->name as $key => $value) {
            $sectionId = $request->section_id[$key] ?? null;

            if ($sectionId) {
                Section::where('id', $sectionId)->update([
                    'name' => $value,
                    'slug' => Str::slug($value),
                    'type' => $request->type[$key] ?? null,
                    'is_required' => $request->is_required[$key] ?? 'no'
                ]);
            } else {
                Section::create([
                    'forms_id' => $request->forms_id,
                    'name' => $value,
                    'slug' => Str::slug($value),
                    'type' => $request->type[$key] ?? null,
                    'is_required' => $request->is_required[$key] ?? 'no'
                ]);
            }
        }

        return redirect()->route('form.show', ['id' => $request->forms_id, 'slug' => $forms->slug])->with('success', 'Successfully Customize Form.');
    }


    public function deleteSection($section_id) 
    {
        $section = Section::where('id', $section_id)->first();
        
        $section->delete();

        return back();
    }

    public function publish(string $id) 
    {
        $forms = Form::find($id);
        
        if (!$forms) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'Failed Published Form']);
        }

        $forms->update(['status' => 'publish']);

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfully Published Form']);
    }

    public function unpublish(string $id) 
    {
        $forms = Form::find($id);
        
        if (!$forms) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'Failed Unpublish Form']);
        }

        $forms->update(['status' => 'draft']);

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Successfully Unpublish Form']);
    }
}
