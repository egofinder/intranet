<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DownloadViewController extends Controller
{
    public function index()
    {
        $url1 = Storage::url('temp\output.txt');
        $url2 = Storage::url('temp\output2.txt');
        $url3 = Storage::url('temp\output3.txt');
        $url4 = Storage::url('temp\outputtpo.txt');

        return view('download', compact('url1', 'url2', 'url3', 'url4'));
    }
}
