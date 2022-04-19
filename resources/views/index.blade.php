@extends('layouts.master')

@section('content')
    <div>
        <a class="inline-block rounded bg-blue-600 px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg"
            data-mdb-ripple="true" data-mdb-ripple-color="light" href="/getTPOInfo" role="button">Request
            TPO Info</a>
    </div>
    <br>
    <br>
    <div>
        <a class="inline-block rounded bg-blue-600 px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg"
            data-mdb-ripple="true" data-mdb-ripple-color="light" href="/getLoanInfo" role="button">Request
            Loan Info</a>
    </div>
@endsection
