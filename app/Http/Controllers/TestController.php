<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function index()
    {
        return "index get";
    }

    public function index2()
    {
        return view('test.test');
    }

    public function getUserInfo(Request $request)
    {

        $user_email = $request->EmailAddress;
        $interval = User::findOrFail($user_email);
        return ($interval);
    }

    public function store(Request $request)
    {
        $type = $request->query('type');
        return ($type);
        // $log = new Test;

        // $log->UserID = "test";
        // $log->Activity = "login";
        // $log->Active = 1;
        // $log->save();
    }
}
