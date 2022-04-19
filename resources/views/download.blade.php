@extends('layouts.master')

@section('content')
    <div>
        <div>
            <a href="{{ $url1 }}" download>Encompass Report</a>
        </div>
        <div>
            <a href="{{ $url2 }}" download>Encompass Buyside</a>
        </div>
        <div>
            <a href="{{ $url3 }}" download>Subservicing Data</a>
        </div>
        <div>
            <a href="{{ $url4 }}" download>TPO Info</a>
        </div>

    </div>
@endsection
