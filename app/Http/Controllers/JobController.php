<?php

namespace App\Http\Controllers;

use App\Models\JobLoanInfoExtraLoan;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $extra_loans = JobLoanInfoExtraLoan::all();
        // dd($extra_loans);
        return view('jobview.index', compact('extra_loans'));
    }


    public function store()
    {
        $newLoan = new JobLoanInfoExtraLoan;
        $newLoan->loanNumber = request('loanNumber');
        $newLoan->save();
        return back();
    }

    public function destroy($id)
    {
        JobLoanInfoExtraLoan::destroy($id);
        return back();
    }
}
