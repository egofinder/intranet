<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

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

</div>
{{-- <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    LoanGuid
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 2
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 3
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 4
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 11
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 12
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 13
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 14
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 15
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 16
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 19
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 60
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 65
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 66
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 67
                </th>
                <th scope="col" class="px-6 py-3">
                    Field 68
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
                <tr class="odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                    <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $loan['loanGuid'] }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.2'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.3'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.4'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.11'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.12'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.13'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.14'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.15'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.16'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.19'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.60'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.65'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.66'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.67'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $loan['fields']['Fields.68'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
