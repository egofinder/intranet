<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\DownloadViewController;
use App\Http\Controllers\ExcelTemplateController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentLetterController;
use App\Http\Controllers\JobController;
use Illuminate\Contracts\Queue\Job;
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



Route::get('/get-token', [TokenController::class, 'getToken']);

Route::get('/introspect-token', [TokenController::class, 'introspectToken']);

Route::get('/download', [DownloadViewController::class, 'index']);



Route::get('/job', [JobController::class, 'index']);

Route::get('/job/delete-extra-loan/{id}', [JobController::class, 'destroy']);

Route::post('/job/add-extra-loan', [JobController::class, 'store']);


Route::post('/accounting/merge-image', [AccountingController::class, 'merge_image'])->name('merge.image');

Route::get('/accounting/upload-image', [AccountingController::class, 'index']);


Route::get('/get-tpo-info', function () {
    dispatch((new App\Jobs\GetTPOInfoJob));
    return redirect('/')->with('success', 'Request TPO Info success');
});

Route::get('/get-loan-info', function () {
    dispatch((new App\Jobs\GetLoanInfoJob));
    return redirect('/')->with('success', 'Request Loan Info success');
});



Route::get('/payment-letter', [PaymentLetterController::class, 'index']);


Route::get('/excel-template', [ExcelTemplateController::class, 'index']);

Route::get('/excel-template/cs-funding/{loanNumber}', [ExcelTemplateController::class, 'csFunding']);
Route::get('/excel-template/cs-funding/{loanNumber}/download', [ExcelTemplateController::class, 'csFundingDownload']);

Route::get('/excel-template/vista-point/{loanNumber}', [ExcelTemplateController::class, 'vistaPoint']);
Route::get('/excel-template/vista-point/{loanNumber}/download', [ExcelTemplateController::class, 'vistaPointDownload']);


Route::get('/test', [TestController::class, 'index2']);

Route::get('/timecard', [TestController::class, 'index']);
Route::post('/timecard/store', [TestController::class, 'store']);
ROute::post('/timecard/get-user-info', [TestController::class, 'getUserInfo']);
