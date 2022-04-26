@extends('layouts.master')

@section('content')
    <div>
        <div
            class="m-3 border-b-4 border-blue-700 bg-blue-500 py-2 px-4 font-bold text-white hover:border-blue-300 hover:bg-yellow-300">
            <a href="{{ $url1 }}" download>Encompass Report</a>
        </div>
        <div
            class="m-3 border-b-4 border-blue-700 bg-blue-500 py-2 px-4 font-bold text-white hover:border-blue-300 hover:bg-yellow-300">
            <a href="{{ $url2 }}" download>Encompass Buyside</a>
        </div>
        <div
            class="m-3 border-b-4 border-blue-700 bg-blue-500 py-2 px-4 font-bold text-white hover:border-blue-300 hover:bg-yellow-300">
            <a href="{{ $url3 }}" download>Subservicing Data</a>
        </div>
        <div
            class="m-3 border-b-4 border-blue-700 bg-blue-500 py-2 px-4 font-bold text-white hover:border-blue-300 hover:bg-yellow-300">
            <a href="{{ $url4 }}" download>TPO Info</a>
        </div>

    </div>
@endsection
