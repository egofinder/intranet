<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        // $test = "";
        // dd(!empty($test));
        // dd(date('m/d/Y', strtotime("")));
        dd(public_path('storage/images'));
        // return view('test.test');
    }
}
