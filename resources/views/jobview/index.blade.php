@extends('layouts.master')

@section('content')
    <div class="mt-10 mb-10 flex justify-center">

        <div class="m-5 max-w-sm overflow-hidden rounded shadow-lg">
            <div class="px-6 py-4">
                <div class="mb-2 text-xl font-bold">TPO Info</div>
                <p class="text-base text-gray-700">
                    Export TPO Info to Local Driver
                </p>
            </div>
            <div class="px-6 pt-4 pb-2 text-center">
                <a class="mr-2 mb-2 inline-block rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-blue-300"
                    data-mdb-ripple="true" data-mdb-ripple-color="light" href="/get-tpo-info" role="button">Request</a>
            </div>
        </div>


        <div class="m-5 max-w-sm overflow-hidden rounded shadow-lg">
            <div class="px-6 py-4">
                <div class="mb-2 text-xl font-bold">Loan Info</div>
                <p class="text-base text-gray-700">
                    Export Loan Info to Local Driver
                </p>
                <p class="py-5 text-2xl">Added Loans</p>
                @foreach ($extra_loans as $loan)
                    <div class="flex justify-between py-1">
                        <p class="border-2">
                            {{ $loan->id }}
                        </p>
                        <p class="border-2">
                            {{ $loan->loanNumber }}
                        </p>
                        <a class="border-2" href={{ url('/job/delete-extra-loan') . '/' . $loan->id }}>Delete</a>
                    </div>
                @endforeach
            </div>
            <div class="px-6 pt-4 pb-2 text-center">
                <a class="mr-2 mb-2 inline-block rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-blue-300"
                    data-mdb-ripple="true" data-mdb-ripple-color="light" href="/get-loan-info" role="button">Request</a>
            </div>
        </div>


        <div class="m-5 max-w-sm overflow-hidden rounded shadow-lg">
            <div class="px-6 py-4">
                <div class="mb-2 text-xl font-bold">Add Extra loan to LoanInfo</div>
            </div>
            <div class="px-6 pt-4 pb-2 text-center">
                <form method="post" action="/job/add-extra-loan" id="extra_loan">
                    @csrf
                    <label for="loanNumber" class="mx-4">Loan Number</label>
                    <input type="text" name="loanNumber" id="loanNumber" class="border-2">
                </form>
                <button
                    class="mr-2 mb-2 mt-5 inline-block rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-blue-300"
                    type="submit" form="extra_loan" value="Submit">Submit</button>
            </div>
        </div>


    </div>
@endsection
