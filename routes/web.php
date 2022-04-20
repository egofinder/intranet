<?php

use App\Http\Controllers\DownloadViewController;
use App\Http\Controllers\ExcelTemplateController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/test', [TestController::class, 'export']);


Route::get('/getToken', [TokenController::class, 'getToken']);

Route::get('/introspectToken', [TokenController::class, 'introspectToken']);


Route::get('/download', [DownloadViewController::class, 'index']);


Route::get('/getTPOInfo', function () {

    dispatch((new App\Jobs\GetTPOInfoJob));
    return view('success');
});

Route::get('/getLoanInfo', function () {
    dispatch((new App\Jobs\GetLoanInfoJob));
    return view('success');
});




Route::get('/CSFunding/{loanNumber}', [ExcelTemplateController::class, 'csFunding']);
Route::get('/CSFunding/{loanNumber}/download', [ExcelTemplateController::class, 'csFundingDownload']);

Route::get('/VistaPoint/{loanNumber}', [ExcelTemplateController::class, 'vistaPoint']);
Route::get('/VistaPoint/{loanNumber}/download', [ExcelTemplateController::class, 'vistaPointDownload']);
