<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    function dashboard()
    {
        return view('manger_blogs.dashboard');
    }
}
