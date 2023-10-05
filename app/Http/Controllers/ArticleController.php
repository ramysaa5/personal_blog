<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('user', 'category')->latest('id')->paginate(10);

        return view('manger_blogs.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest('id')->get();
        $tags = Tag::latest('id')->get();
        return view('manger_blogs.articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //validation
        $request->validate([
            'title' => 'required|min:5|max:255',
            'category' => 'required',
            'tags' => 'required',
            'content' => 'required|',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->except('_token', 'image', 'tags', 'category');

        // upload image if exist
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $img_name = rand() . time() . $img->getClientOriginalName();
            $img->move(public_path('images'), $img_name);
            $data['imageUrl'] = $img_name;
        }



        $data['user_id'] = Auth::user()->id;

        $data['category_id'] = $request->category;

        // Save in database

        $article = Article::create($data);

        $article->tags()->sync($request->tags);


        // redirect
        return redirect()->route('admin.articles.create')
            ->with('msg', 'Article Added Successfully')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->with('tags')->get();
        return view('manger_blogs.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::latest('id')->get();
        $tags = Tag::latest('id')->get();

        return view('manger_blogs.articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //validation
        $request->validate([
            'title' => 'required|min:5|max:255',
            'category' => 'required',
            'tags' => 'required',
            'content' => 'required|',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);


        $data = $request->except('_token', 'image', 'tags', 'category');

        // upload image if exist
        if ($request->hasFile('image')) {
            File::delete(public_path('images/' . $article->image));

            $img = $request->file('image');
            $img_name = rand() . time() . $img->getClientOriginalName();
            $img->move(public_path('images'), $img_name);
            $data['imageUrl'] = $img_name;
        }



        //  use Auth
        $data['user_id'] = Auth::user()->id;

        $data['updated_by'] = Auth::user()->id;

        $data['category_id'] = $request->category;

        // Save in database

        $article->update($data);

        $article->tags()->sync($request->tags);


        // redirect
        return redirect()->route('admin.articles.index')
            ->with('msg', 'Article Updated Successfully')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article, Request $request)
    {
        $data = $request->only('deleted_by');


        $data['deleted_by'] = Auth::user()->id;

        $article->update($data);

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('msg', 'Article Deleted Successfully')
            ->with('type', 'success');
    }

    function trash()
    {
        $articles = Article::with('user', 'category')->onlyTrashed()->latest('id')->paginate(10);

        return view('manger_blogs.articles.trash', compact('articles'));
    }

    function restore($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        $article->restore();

        return redirect()->route('admin.articles.trash')
            ->with('msg', 'Article Restored Successfully')
            ->with('type', 'success');
    }

    function forcedelete($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        File::delete(public_path('images/' . $article->image));
        $article->forcedelete();

        return redirect()->route('admin.articles.trash')
            ->with('msg', 'Article Deleted Successfully')
            ->with('type', 'success');
    }
}
