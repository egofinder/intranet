<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TeamsNotificationController;


class TestController extends Controller
{

    public function test()
    {
        phpinfo();
    }
}
