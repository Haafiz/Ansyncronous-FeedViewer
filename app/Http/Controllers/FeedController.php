<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function view()
    {
        return view('feedviewer');
    }
}
