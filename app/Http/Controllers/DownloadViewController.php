<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DownloadViewController extends Controller
{
    public function index()
    {
        // $url1 = Storage::url('temp\encompass_report.txt');
        // $url2 = Storage::url('temp\encompass_buyside.txt');
        // $url3 = Storage::url('temp\subservicing_data.txt');
        // $url4 = Storage::url('temp\TPOinfo.txt');

        // return view('download', compact('url1', 'url2', 'url3', 'url4'));
        // $temp = Storage::disk('local2')->allDirectories();
        // dd($temp);
    }
}
