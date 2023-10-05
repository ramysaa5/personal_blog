<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function dashboard()
    {
        return view('client.dashboard');
    }

    function index()
    {
        $articles = Article::with('user', 'category')->latest('id')->paginate(10);
        return view('client.index', compact('articles'));
    }

    function show($id)
    {
        $article = Article::FindOrFail($id);
        $article->with('tags')->get();
        return view('client.show', compact('article'));
    }
}
