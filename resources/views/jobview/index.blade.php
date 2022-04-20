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
                    data-mdb-ripple="true" data-mdb-ripple-color="light" href="/getTPOInfo" role="button">Request</a>
            </div>
        </div>


        <div class="m-5 max-w-sm overflow-hidden rounded shadow-lg">
            <div class="px-6 py-4">
                <div class="mb-2 text-xl font-bold">Loan Info</div>
                <p class="text-base text-gray-700">
                    Export Loan Info to Local Driver
                </p>
            </div>
            <div class="px-6 pt-4 pb-2 text-center">
                <a class="mr-2 mb-2 inline-block rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-blue-300"
                    data-mdb-ripple="true" data-mdb-ripple-color="light" href="/getLoanInfo" role="button">Request</a>
            </div>
        </div>
    </div>
@endsection
