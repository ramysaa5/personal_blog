<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest('id')->paginate(10);
        return view('manger_blogs.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manger_blogs.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation

        $request->validate([
            'name' => 'required|string|min:2'
        ]);
        $exists = Tag::where('name', '=', $request->name)->exists();
        if ($exists) {
            return redirect()->route('admin.tags.create')
                ->with('msg', 'Opes!! Sorry, this Tag is in exists')
                ->with('type', 'danger');
        }

        // save in Database
        $data = $request->except('_token');
        Tag::create($data);

        // redirect to index page

        return redirect()->route('admin.tags.create')
            ->with('msg', 'Tags Added Successfully')
            ->with('type', 'success');
    }


    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('manger_blogs.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|min:2'
        ]);

        $exists = Tag::where('name', '=', $request->name)->exists();
        if ($exists) {
            return redirect()->route('admin.tags.index')
                ->with('msg', 'Opes!! Sorry, this Tag is in exists')
                ->with('type', 'danger');
        }

        // Update in Database
        $data = $request->except('_token');

        $tag->update($data);

        // redirect to index page

        return redirect()->route('admin.tags.index')
            ->with('msg', 'Tags Updated Successfully')
            ->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();


        return 'Deleted';
    }


    function trash()
    {
        $tags = Tag::onlyTrashed()->latest('id')->paginate(10);
        return view('manger_blogs.tags.trash', compact('tags'));
    }

    function restore($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->restore();

        return redirect()->route('admin.tags.trash')
            ->with('msg', 'Tags Restored Successfully')
            ->with('type', 'danger');
    }

    function forcedelete($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->forcedelete();

        return redirect()->route('admin.tags.trash')
            ->with('msg', 'Tags Deleted Successfully')
            ->with('type', 'danger');
    }
}
