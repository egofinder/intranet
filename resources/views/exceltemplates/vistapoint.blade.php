@extends('layouts.master')

@section('content')
    <div>
        <table>
            <tr>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Number</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Program</th>
                <th class="table-auto border-2 border-solid border-sky-500">Borrower Last Name</th>
                <th class="table-auto border-2 border-solid border-sky-500">Borrower First Name</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Amount</th>
                <th class="table-auto border-2 border-solid border-sky-500">Note Rate</th>
                <th class="table-auto border-2 border-solid border-sky-500">LTV</th>
                <th class="table-auto border-2 border-solid border-sky-500">Combined LTV</th>
                <th class="table-auto border-2 border-solid border-sky-500">Borrower minimum Fico</th>
                <th class="table-auto border-2 border-solid border-sky-500">Income Total Mo Income (Borr/Co-Borr)</th>
                <th class="table-auto border-2 border-solid border-sky-500">BORROWER SELF EMPLOYED</th>
                <th class="table-auto border-2 border-solid border-sky-500">CO-BORROWER SELF EMPLOYED</th>
                <th class="table-auto border-2 border-solid border-sky-500">Co-Borr Min Fico</th>
                <th class="table-auto border-2 border-solid border-sky-500">INCOME CO-BORR TOTAL INCOME</th>
                <th class="table-auto border-2 border-solid border-sky-500">Co-Borrower First Name</th>
                <th class="table-auto border-2 border-solid border-sky-500">Co-Borrower Last Name</th>
                <th class="table-auto border-2 border-solid border-sky-500">Occupancy (P/S/I)</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Purpose</th>
                <th class="table-auto border-2 border-solid border-sky-500">Trans Details Cash From Borr</th>
                <th class="table-auto border-2 border-solid border-sky-500">Bottom Ratio</th>
                <th class="table-auto border-2 border-solid border-sky-500">LOCK REQUEST DOC TYPE</th>
                <th class="table-auto border-2 border-solid border-sky-500">Interest Only Mos</th>
                <th class="table-auto border-2 border-solid border-sky-500">Prepayment Penalty Period</th>
                <th class="table-auto border-2 border-solid border-sky-500">Prepay Penalty</th>
                <th class="table-auto border-2 border-solid border-sky-500">Subject Property Address</th>
                <th class="table-auto border-2 border-solid border-sky-500">Subject Property City</th>
                <th class="table-auto border-2 border-solid border-sky-500">Subject Property State</th>
                <th class="table-auto border-2 border-solid border-sky-500">Subject Property Zip</th>
                <th class="table-auto border-2 border-solid border-sky-500">Appraised Value</th>
                <th class="table-auto border-2 border-solid border-sky-500">Subject Property Purchase Price</th>
                <th class="table-auto border-2 border-solid border-sky-500">BORR DECLARATIONS J</th>
                <th class="table-auto border-2 border-solid border-sky-500">CO-BORR DECLARATIONS J</th>
                <th class="table-auto border-2 border-solid border-sky-500">SUBJECT PROPERTY TYPE</th>
                <th class="table-auto border-2 border-solid border-sky-500">Subject Property # Units</th>
                <th class="table-auto border-2 border-solid border-sky-500">Impound Types</th>
                <th class="table-auto border-2 border-solid border-sky-500">Amortization Type</th>
                <th class="table-auto border-2 border-solid border-sky-500">Margin</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Info ARM Index</th>
                <th class="table-auto border-2 border-solid border-sky-500">LOAN INFO ARM RATE CAP</th>
                <th class="table-auto border-2 border-solid border-sky-500">Life Cap</th>
                <th class="table-auto border-2 border-solid border-sky-500">Floor Rate</th>
                <th class="table-auto border-2 border-solid border-sky-500">Term Due In</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Info ARM First Period Change</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Term</th>
                <th class="table-auto border-2 border-solid border-sky-500">Docs Sent</th>
                <th class="table-auto border-2 border-solid border-sky-500">First Pymt Date</th>
                <th class="table-auto border-2 border-solid border-sky-500">Servicing Payment Due Date</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Amount</th>
                <th class="table-auto border-2 border-solid border-sky-500">QM Status</th>
                <th class="table-auto border-2 border-solid border-sky-500">Qualified Mortgage Status</th>
                <th class="table-auto border-2 border-solid border-sky-500">Loan Team Member Email - TPO LOAN OFFICER</th>
                <th class="table-auto border-2 border-solid border-sky-500">Warehouse Co Name</th>
                <th class="table-auto border-2 border-solid border-sky-500">Universal Loan Id</th>
                <th class="table-auto border-2 border-solid border-sky-500">Guidelines Used</th>
            </tr>
            <tr>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['364'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1401'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['4000'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['4002'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['2'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['3'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['353'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['976'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1484'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['273'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['FE0115'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['FE0215'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1502'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['911'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['4004'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['4006'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1811'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['384'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['L206R'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['742'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['2867'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1177'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['HMDA.X82'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['RE88395.X322'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['11'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['12'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['14'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['15'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['356'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['136'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['URLA.X102'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['URLA.X103'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1041'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['16'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['2962'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['608'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['689'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['688'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['695'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['247'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1699'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['325'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['696'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['1347'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['3925']) }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['682']) }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['3514'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['2'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['HMDA.X26'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['HMDA.X26'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">
                    {{ $result['LoanTeamMember.Email.TPO Loan Officer'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['VEND.X200'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500">{{ $result['HMDA.X28'] }}</td>
                <td class="table-auto border-2 border-solid border-red-500"></td>
            </tr>
        </table>

        <form action="{{ $result['loanNumber'] . '/download' }}" id=form>
        </form>
        <button class="rounded-full bg-blue-500 py-2 px-4 font-bold text-white hover:bg-blue-700" form="form">
            Download
        </button>
    </div>
@endsection
