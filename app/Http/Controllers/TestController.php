<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TeamsNotificationController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestExport;


class TestController extends Controller
{

    public function export()
    {
        return Excel::download(new TestExport, 'invoices.xlsx');
    }
}
