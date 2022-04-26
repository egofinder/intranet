@extends('layouts.master')

@section('content')
    <div>
        <input type="text" id="loanNumber" placeholder="Enter Loan Number" class="m-4 border-2 bg-amber-200 text-xl">
    </div>
    <div>
        <button
            class="m-4 rounded border-b-4 border-blue-700 bg-blue-500 py-2 px-4 font-bold text-white hover:border-blue-500 hover:bg-blue-400"
            onclick="createDynamicURL()" id="cs-funding">CS Funding Request</button>

    </div>
    <div>
        <button
            class="m-4 rounded border-b-4 border-blue-700 bg-blue-500 py-2 px-4 font-bold text-white hover:border-blue-500 hover:bg-blue-400"
            onclick="createDynamicURL()" id='vista-point'>Vista Point Request</button>

    </div>

    <script>
        function createDynamicURL() {
            var URL = "/excel-template/";
            var loanNumber = document.getElementById("loanNumber").value;
            URL += event.srcElement.id + "/";
            URL += loanNumber;
            location.href = URL;
        }
    </script>
@endsection
