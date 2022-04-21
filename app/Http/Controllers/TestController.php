<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentLetter;
use App\Models\EncompassReport;
use Illuminate\Support\Facades\Http;
use App\Models\Token;


class TestController extends Controller
{

    public function index(Request $request)
    {

        // Retrieve Information From DB
        // dd($request->query(), $request->query('loanNumber'), $request->query('startTID'), $request->query('endTID'), $request->query('AID'), $request->query('TID'));
        if ($request->query('AID') != '0') {
            // $sql_1 = "SELECT PaymentDate, DATE, Total, Impound, PrincipalInterest, MonthlyPremium FROM payment_letter WHERE PACLOAN = '$loanNumber' AND DEL != 'DEL' AND AID = '$AID' AND TID BETWEEN '$startTID' AND '$endTID'";

            $result1 = PaymentLetter::where('PACLOAN', '=', $request->query('loanNumber'), 'and')
                ->where('DEL', '!=', 'DEL', 'and')
                ->where('AID', '=', $request->query('AID'), 'and')
                ->whereBetween('TID', [$request->query('startTID'), $request->query('endTID')])
                ->first();
            dd($result1);
        } else {

            dd('short Query');
            // $sql_1 = "SELECT PaymentDate, DATE, Total, Impound, PrincipalInterest, MonthlyPremium FROM payment_letter WHERE TID = '$TID' AND DEL != 'DEL'";
            // $result1 = PaymentLetter::find(13);

        }
        // $result2 = EncompassReport::find(13);



        // Retrieve Information From Encompass
        // $access_token = Token::find(1)->access_token;
        // $response = Http::acceptJson()->withToken($access_token)->post(
        //     'https://api.elliemae.com/encompass/v1/loanPipeline',
        //     [
        //         "filter" => [
        //             "terms" => [
        //                 [
        //                     "canonicalName" => "Fields.364",
        //                     "value" => $loanNumber,
        //                     "matchType" => "exact"
        //                 ],
        //             ]
        //         ]
        //     ]
        // );
        // $decoded = json_decode($response->body(), true);
        // $sample = collect($decoded);
        // $loanGuid = $sample[0]['loanGuid'];
        // $response = Http::acceptJson()->withToken($access_token)->post(
        //     'https://api.elliemae.com/encompass/v1/loans/' . $loanGuid . '/fieldReader',
        //     [
        //         "SERVICE.X1",
        //         "SERVICE.X2",
        //         "SERVICE.X3",
        //         "SERVICE.X4",
        //         "SERVICE.X5",
        //         "SERVICE.X6",
        //         "SERVICE.X7",
        //         "SERVICE.X13",
        //         "SERVICE.X14",
        //         "SERVICE.X15",
        //         "SERVICE.X20",
        //         "SERVICE.X24",
        //         "SERVICE.X25",
        //         "SERVICE.X26",
        //         "SERVICE.X32",
        //         "SERVICE.X33",
        //         "SERVICE.X34",
        //         "SERVICE.X35",
        //         "SERVICE.X36",
        //         "SERVICE.X37",
        //         "SERVICE.X42",
        //         "SERVICE.X44",
        //         "SERVICE.X57",
        //         "SERVICE.X77",
        //         "SERVICE.X81",
        //         "SERVICE.X82",
        //         "3",
        //         "11",
        //         "12",
        //         "14",
        //         "15",
        //         "68",
        //         "69",
        //         "672",
        //         "674"
        //     ]
        // );

        // $decoded = json_decode($response->body(), true);
        // $result3 = array();

        // foreach ($decoded as $item) {
        //     $result3[$item['fieldId']] = $item['value'];
        // }






        // dd($result1, $result2, $result3);
    }
}
