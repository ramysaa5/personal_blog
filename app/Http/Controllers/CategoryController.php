<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('id')->paginate(10);
        return view('manger_blogs.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manger_blogs.categories.create');
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
        $exists = Category::where('name', '=', $request->name)->exists();
        if ($exists) {
            return redirect()->route('admin.categories.create')
                ->with('msg', 'Opes!! Sorry, this Category is in exists')
                ->with('type', 'danger');
        }

        // save in Database
        $data = $request->except('_token');
        Category::create($data);

        // redirect to index page

        return redirect()->route('admin.categories.create')
            ->with('msg', 'Categories Added Successfully')
            ->with('type', 'success');
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('manger_blogs.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:2'
        ]);

        $exists = Category::where('name', '=', $request->name)->exists();
        if ($exists) {
            return redirect()->route('admin.categories.index')
                ->with('msg', 'Opes!! Sorry, this Category is in exists')
                ->with('type', 'danger');
        }

        // Update in Database
        $data = $request->except('_token');
        $category->update($data);

        // redirect to index page

        return redirect()->route('admin.categories.index')
            ->with('msg', 'categories Updated Successfully')
            ->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();


        return 'Deleted';
    }


    function trash()
    {
        $categories = Category::onlyTrashed()->latest('id')->paginate(10);
        return view('manger_blogs.categories.trash', compact('categories'));
    }

    function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.trash')
            ->with('msg', 'categories Restored Successfully')
            ->with('type', 'danger');
    }

    function forcedelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forcedelete();

        return redirect()->route('admin.categories.trash')
            ->with('msg', 'categories Deleted Successfully')
            ->with('type', 'danger');
    }
}
