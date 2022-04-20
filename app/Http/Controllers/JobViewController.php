<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobViewController extends Controller
{
    public function index()
    {
        return view('jobview.index');
    }
}
