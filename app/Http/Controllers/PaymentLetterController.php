<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentLetter;
use App\Models\EncompassReport;
use Illuminate\Support\Facades\Http;
use App\Models\Token;


class PaymentLetterController extends Controller
{

    public function index(Request $request)
    {
        TokenController::introspectToken();
        $access_token = Token::find(1)->access_token;

        $loanNumbers = array();
        $final_result = array();
        $loans = array();

        if ($request->query('tid')) {
            $result_1 = PaymentLetter::select('PACLOAN', 'PaymentDate', 'DATE', 'Total', 'Impound', 'PrincipalInterest', 'MonthlyPremium')->where('TID', $request->query('tid'))->get();
        } else {
            $result_1 = PaymentLetter::select('PACLOAN', 'PaymentDate', 'DATE', 'Total', 'Impound', 'PrincipalInterest', 'MonthlyPremium')->where('AID', '=', $request->query('aid'), 'and')
                ->where('DEL', '!=', 'DEL', 'and')
                ->whereBetween('TID', [$request->query('start'), $request->query('end')])
                ->orderBy('TID', 'desc')->get();
        }

        $result_1 = json_decode($result_1, false);
        foreach ($result_1 as $item) {
            array_push($loanNumbers, $item->PACLOAN);

            $final_result[$item->PACLOAN] = array(
                'loanNumber' => $item->PACLOAN,
                'paymentDue' => $item->PaymentDate,
                'statementDate' => $item->DATE,
                'total' => $item->Total,
                'impound' => $item->Impound,
                'principalInterest' => $item->PrincipalInterest,
                'monthlyPremium' => $item->MonthlyPremium
            );

            $final_result[$item->PACLOAN]['total'] = str_replace("$", "", $item->Total);
            $final_result[$item->PACLOAN]['total'] = str_replace(",", "", $final_result[$item->PACLOAN]['total']);
            $final_result[$item->PACLOAN]['total'] = floatval($final_result[$item->PACLOAN]['total']);
            $final_result[$item->PACLOAN]['total'] = number_format($final_result[$item->PACLOAN]['total'], 2);

            $final_result[$item->PACLOAN]['impound'] = str_replace("$", "", $item->Impound);
            $final_result[$item->PACLOAN]['impound'] = str_replace(",", "", $final_result[$item->PACLOAN]['impound']);
            $final_result[$item->PACLOAN]['impound'] = floatval($final_result[$item->PACLOAN]['impound']);
            $final_result[$item->PACLOAN]['impound'] = number_format($final_result[$item->PACLOAN]['impound'], 2);

            $final_result[$item->PACLOAN]['principalInterest'] = str_replace("$", "", $item->PrincipalInterest);
            $final_result[$item->PACLOAN]['principalInterest'] = str_replace(",", "", $final_result[$item->PACLOAN]['principalInterest']);
            $final_result[$item->PACLOAN]['principalInterest'] = floatval($final_result[$item->PACLOAN]['principalInterest']);
            $final_result[$item->PACLOAN]['principalInterest'] = number_format($final_result[$item->PACLOAN]['principalInterest'], 2);

            $final_result[$item->PACLOAN]['monthlyPremium'] = str_replace("$", "", $item->MonthlyPremium);
            $final_result[$item->PACLOAN]['monthlyPremium'] = str_replace(",", "", $final_result[$item->PACLOAN]['monthlyPremium']);
            $final_result[$item->PACLOAN]['monthlyPremium'] = floatval($final_result[$item->PACLOAN]['monthlyPremium']);
            $final_result[$item->PACLOAN]['monthlyPremium'] = number_format($final_result[$item->PACLOAN]['monthlyPremium'], 2);
        }

        $result_2 = EncompassReport::select(
            'TransDetailsLoan',
            'BorrowerFirstName',
            'BorrowerLastName',
            'Occupancy',
            'BorrMailingCheck',
            'SubjectPropertyAddress',
            'SubjectPropertyCity',
            'SubjectPropertyState',
            'SubjectPropertyZip',
            'BorrPresentAddr',
            'BorrPresentCity',
            'BorrPresentState',
            'BorrPresentZip',
            'BorrMailingAddr',
            'BorrMailingCity',
            'BorrMailingState',
            'BorrMailingZip'
        )->whereIn('TransDetailsLoan', $loanNumbers)->get();
        $result_2 = json_decode($result_2, false);

        foreach ($result_2 as $item) {
            $final_result[$item->TransDetailsLoan]['firstName'] = $item->BorrowerFirstName;
            $final_result[$item->TransDetailsLoan]['lastName'] = $item->BorrowerLastName;
            $final_result[$item->TransDetailsLoan]['occupancy'] = $item->Occupancy;
            $final_result[$item->TransDetailsLoan]['mailingCheck'] = $item->BorrMailingCheck;

            $final_result[$item->TransDetailsLoan]['address_1'] = $item->SubjectPropertyAddress;
            $final_result[$item->TransDetailsLoan]['city_1'] = $item->SubjectPropertyCity;
            $final_result[$item->TransDetailsLoan]['state_1'] = $item->SubjectPropertyState;
            $final_result[$item->TransDetailsLoan]['zip_1'] = $item->SubjectPropertyZip;

            $final_result[$item->TransDetailsLoan]['address_2'] = $item->BorrPresentAddr;
            $final_result[$item->TransDetailsLoan]['city_2'] = $item->BorrPresentCity;
            $final_result[$item->TransDetailsLoan]['state_2'] = $item->BorrPresentState;
            $final_result[$item->TransDetailsLoan]['zip_2'] = $item->BorrPresentZip;

            $final_result[$item->TransDetailsLoan]['address_3'] = $item->BorrMailingAddr;
            $final_result[$item->TransDetailsLoan]['city_3'] = $item->BorrMailingCity;
            $final_result[$item->TransDetailsLoan]['state_3'] = $item->BorrMailingState;
            $final_result[$item->TransDetailsLoan]['zip_3'] = $item->BorrMailingZip;

            if ($item->Occupancy == 'PrimaryResidence') {

                if ($item->BorrMailingCheck == 'N' || $item->BorrMailingCheck == ' ') {
                    if ($item->BorrMailingAddr) {
                        $final_result[$item->TransDetailsLoan]['maddress'] = $item->BorrMailingAddr;
                        $final_result[$item->TransDetailsLoan]['mcity'] = $item->BorrMailingCity;
                        $final_result[$item->TransDetailsLoan]['mstate'] = $item->BorrMailingState;
                        $final_result[$item->TransDetailsLoan]['mzip'] = $item->BorrMailingZip;
                    } else {
                        $final_result[$item->TransDetailsLoan]['maddress'] = $item->SubjectPropertyAddress;
                        $final_result[$item->TransDetailsLoan]['mcity'] = $item->SubjectPropertyCity;
                        $final_result[$item->TransDetailsLoan]['mstate'] = $item->SubjectPropertyState;
                        $final_result[$item->TransDetailsLoan]['mzip'] = $item->SubjectPropertyZip;
                    }
                } else {
                    $final_result[$item->TransDetailsLoan]['maddress'] = $item->SubjectPropertyAddress;
                    $final_result[$item->TransDetailsLoan]['mcity'] = $item->SubjectPropertyCity;
                    $final_result[$item->TransDetailsLoan]['mstate'] = $item->SubjectPropertyState;
                    $final_result[$item->TransDetailsLoan]['mzip'] = $item->SubjectPropertyZip;
                }
            } else {

                if ($item->BorrMailingCheck == 'Y') {
                    $final_result[$item->TransDetailsLoan]['maddress'] = $item->BorrPresentAddr;
                    $final_result[$item->TransDetailsLoan]['mcity'] = $item->BorrPresentCity;
                    $final_result[$item->TransDetailsLoan]['mstate'] = $item->BorrPresentState;
                    $final_result[$item->TransDetailsLoan]['mzip'] = $item->BorrPresentZip;
                } else {
                    $final_result[$item->TransDetailsLoan]['maddress'] = $item->BorrMailingAddr;
                    $final_result[$item->TransDetailsLoan]['mcity'] = $item->BorrMailingCity;
                    $final_result[$item->TransDetailsLoan]['mstate'] = $item->BorrMailingState;
                    $final_result[$item->TransDetailsLoan]['mzip'] = $item->BorrMailingZip;
                }
            };
        }

        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v3/loanPipeline',
            [
                "fields" => [
                    "Fields.SERVICE.X1",
                    "Fields.SERVICE.X2",
                    "Fields.SERVICE.X3",
                    "Fields.SERVICE.X4",
                    "Fields.SERVICE.X5",
                    "Fields.SERVICE.X6",
                    "Fields.SERVICE.X7",
                    "Fields.SERVICE.X13",
                    // Fields.SERVICE.X14 has canonicalName Loan.ISPaymentDue,
                    // "Loan.ISPaymentDue",
                    "Fields.SERVICE.X15",
                    "Fields.SERVICE.X20",
                    "Fields.SERVICE.X24",
                    "Fields.SERVICE.X25",
                    "Fields.SERVICE.X26",
                    "Fields.SERVICE.X32",
                    "Fields.SERVICE.X33",
                    "Fields.SERVICE.X34",
                    "Fields.SERVICE.X35",
                    "Fields.SERVICE.X36",
                    "Fields.SERVICE.X37",
                    "Fields.SERVICE.X42",
                    "Fields.SERVICE.X44",
                    "Fields.SERVICE.X57",
                    "Fields.SERVICE.X77",
                    "Fields.SERVICE.X81",
                    "Fields.SERVICE.X82",
                    "Fields.3",
                    "Fields.11",
                    "Fields.12",
                    "Fields.14",
                    "Fields.15",
                    "Fields.68",
                    "Fields.69",
                    "Fields.364",
                    "Fields.672",
                    "Fields.674",
                ],
                "filter" => [
                    "terms" => [
                        [
                            "canonicalName" => "Fields.364",
                            // "value" => $date,
                            "value" => $loanNumbers,
                            "matchType" => "MultiValue"
                        ],
                    ]
                ]
            ]
        );
        $decoded = json_decode($response->body(), true);

        // dd($decoded, $final_result);
        foreach ($decoded as $item) {

            $loans[$item['fields']['Fields.364']]['SERVICE.X1'] = $final_result[$item['fields']['Fields.364']]['loanNumber'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X2'] = $final_result[$item['fields']['Fields.364']]['firstName'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X3'] = $final_result[$item['fields']['Fields.364']]['lastName'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X4'] = $final_result[$item['fields']['Fields.364']]['maddress'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X5'] = $final_result[$item['fields']['Fields.364']]['mcity'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X6'] = $final_result[$item['fields']['Fields.364']]['mstate'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X7'] = $final_result[$item['fields']['Fields.364']]['mzip'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X13'] = $final_result[$item['fields']['Fields.364']]['statementDate'];
            $loans[$item['fields']['Fields.364']]['SERVICE.X14'] = date('m/d/Y', strtotime($final_result[$item['fields']['Fields.364']]['paymentDue']));
            $loans[$item['fields']['Fields.364']]['SERVICE.X15'] = date('m/d/Y', (strtotime($final_result[$item['fields']['Fields.364']]['paymentDue']) + (($item['fields']['Fields.672'] - 1) * 3600 * 24)));
            $loans[$item['fields']['Fields.364']]['SERVICE.X20'] = number_format(floatval($final_result[$item['fields']['Fields.364']]['impound']), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X24'] = number_format(floatval(str_replace(",", "", $final_result[$item['fields']['Fields.364']]['total'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X25'] = round(floatval(str_replace(",", "", $loans[$item['fields']['Fields.364']]['SERVICE.X24'])) * $item['fields']['Fields.674'] / 100, 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X26'] = number_format(round(floatval(str_replace(",", "", $loans[$item['fields']['Fields.364']]['SERVICE.X24'])) + floatval(str_replace(",", "", $loans[$item['fields']['Fields.364']]['SERVICE.X25'])), 2), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X32'] = ($item['fields']['Fields.SERVICE.X32']) ? date('m/d/Y', strtotime($item['fields']['Fields.SERVICE.X32'])) : "-";
            $loans[$item['fields']['Fields.364']]['SERVICE.X33'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X33'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X34'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X34'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X35'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X35'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X36'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X36'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X37'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X37'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X42'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X42'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X44'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X44'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X57'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X57'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X77'] = (floatval($final_result[$item['fields']['Fields.364']]['monthlyPremium']) > 0) ? number_format(str_replace(",", "", $final_result[$item['fields']['Fields.364']]['monthlyPremium']), 2) : "";
            $loans[$item['fields']['Fields.364']]['SERVICE.X81'] = number_format(floatval(str_replace(",", "", $item['fields']['Fields.SERVICE.X81'])), 2);
            $loans[$item['fields']['Fields.364']]['SERVICE.X82'] = $final_result[$item['fields']['Fields.364']]['principalInterest'];
            $loans[$item['fields']['Fields.364']]['3'] = number_format($item['fields']['Fields.3'], 3);
            $loans[$item['fields']['Fields.364']]['11'] = $item['fields']['Fields.11'];
            $loans[$item['fields']['Fields.364']]['12'] = $item['fields']['Fields.12'];
            $loans[$item['fields']['Fields.364']]['14'] = $item['fields']['Fields.14'];
            $loans[$item['fields']['Fields.364']]['15'] = $item['fields']['Fields.15'];
            $loans[$item['fields']['Fields.364']]['68'] = $item['fields']['Fields.68'];
            $loans[$item['fields']['Fields.364']]['69'] = $item['fields']['Fields.69'];
            $loans[$item['fields']['Fields.364']]['364'] = $item['fields']['Fields.364'];
            $loans[$item['fields']['Fields.364']]['672'] = $item['fields']['Fields.672'];
            $loans[$item['fields']['Fields.364']]['674'] = $item['fields']['Fields.674'];


            $loans[$item['fields']['Fields.364']]['SERVICE.X20'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X20']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X20']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X24'] = (!empty($loans[$item['fields']['Fields.364']]['SERVICE.X24'])) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X24']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X25'] = (!empty($loans[$item['fields']['Fields.364']]['SERVICE.X25'])) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X25']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X26'] = (!empty($loans[$item['fields']['Fields.364']]['SERVICE.X26'])) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X26']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X33'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X33']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X33']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X34'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X34']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X34']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X35'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X35']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X35']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X36'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X36']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X36']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X37'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X37']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X37']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X42'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X42']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X42']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X44'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X44']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X44']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X57'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X57']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X57']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X77'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X77']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X77']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X81'] = (($loans[$item['fields']['Fields.364']]['SERVICE.X81']) > 0) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X81']) : '-';
            $loans[$item['fields']['Fields.364']]['SERVICE.X82'] = (!empty($loans[$item['fields']['Fields.364']]['SERVICE.X82'])) ? ('$' . $loans[$item['fields']['Fields.364']]['SERVICE.X82']) : '-';
        }

        // dd($final_result);
        return view('paymentletter.index')->with('loans', $loans);
    }



    public function test(Request $request)
    {

        TokenController::introspectToken();
        $access_token = Token::find(1)->access_token;

        // Retrieve LoanNumbers From input query
        if ($request->query('tid')) {
            $result = PaymentLetter::select('PACLOAN', 'PaymentDate', 'DATE', 'Total', 'Impound', 'PrincipalInterest', 'MonthlyPremium')->where('TID', $request->query('tid'))->get();
        } else {
            $result = PaymentLetter::select('PACLOAN', 'PaymentDate', 'DATE', 'Total', 'Impound', 'PrincipalInterest', 'MonthlyPremium')->where('AID', '=', $request->query('aid'), 'and')
                ->where('DEL', '!=', 'DEL', 'and')
                ->whereBetween('TID', [$request->query('start'), $request->query('end')])
                ->orderBy('TID', 'desc')->get();
        }

        $loans = array();
        $count = 0;
        $result = json_decode($result, false);
        foreach ($result as $item) {
            $count++;
            $loans[$count] = array();
            $temp = array();
            $temp['loanNumber'] = $item->PACLOAN;
            $temp['paymentDue'] = $item->PaymentDate;
            $temp['statementDate'] = $item->DATE;

            $temp['total'] = str_replace("$", "", $item->Total);
            $temp['total'] = str_replace(",", "", $temp['total']);
            $temp['total'] = floatval($temp['total']);
            $temp['total'] = number_format($temp['total'], 2);

            $temp['impound'] = str_replace("$", "", $item->Impound);
            $temp['impound'] = str_replace(",", "", $temp['impound']);
            $temp['impound'] = floatval($temp['impound']);
            $temp['impound'] = number_format($temp['impound'], 2);

            $temp['principalInterest'] = str_replace("$", "", $item->PrincipalInterest);
            $temp['principalInterest'] = str_replace(",", "", $temp['principalInterest']);
            $temp['principalInterest'] = floatval($temp['principalInterest']);
            $temp['principalInterest'] = number_format($temp['principalInterest'], 2);

            $temp['monthlyPremium'] = str_replace("$", "", $item->MonthlyPremium);
            $temp['monthlyPremium'] = str_replace(",", "", $temp['monthlyPremium']);
            $temp['monthlyPremium'] = floatval($temp['monthlyPremium']);
            $temp['monthlyPremium'] = number_format($temp['monthlyPremium'], 2);

            $result = EncompassReport::select(
                'BorrowerFirstName',
                'BorrowerLastName',
                'Occupancy',
                'BorrMailingCheck',
                'SubjectPropertyAddress',
                'SubjectPropertyCity',
                'SubjectPropertyState',
                'SubjectPropertyZip',
                'BorrPresentAddr',
                'BorrPresentCity',
                'BorrPresentState',
                'BorrPresentZip',
                'BorrMailingAddr',
                'BorrMailingCity',
                'BorrMailingState',
                'BorrMailingZip'
            )->where('TransDetailsLoan', $temp['loanNumber'])->first();
            $result = json_decode($result, false);


            $temp['firstName'] = $result->BorrowerFirstName;
            $temp['lastName'] = $result->BorrowerLastName;
            $temp['occupancy'] = $result->Occupancy;
            $temp['mailingCheck'] = $result->BorrMailingCheck;

            $temp['address_1'] = $result->SubjectPropertyAddress;
            $temp['city_1'] = $result->SubjectPropertyCity;
            $temp['state_1'] = $result->SubjectPropertyState;
            $temp['zip_1'] = $result->SubjectPropertyZip;

            $temp['address_2'] = $result->BorrPresentAddr;
            $temp['city_2'] = $result->BorrPresentCity;
            $temp['state_2'] = $result->BorrPresentState;
            $temp['zip_2'] = $result->BorrPresentZip;

            $temp['address_3'] = $result->BorrMailingAddr;
            $temp['city_3'] = $result->BorrMailingCity;
            $temp['state_3'] = $result->BorrMailingState;
            $temp['zip_3'] = $result->BorrMailingZip;

            if ($temp['occupancy'] == 'PrimaryResidence') {

                if ($temp['mailingCheck'] == 'N' || $temp['mailingCheck'] == ' ') {
                    if ($temp['address_3']) {
                        $temp['maddress'] = $temp['address_3'];
                        $temp['mcity'] = $temp['city_3'];
                        $temp['mstate'] = $temp['state_3'];
                        $temp['mzip'] = $temp['zip_3'];
                    } else {
                        $temp['maddress'] = $temp['address_1'];
                        $temp['mcity'] = $temp['city_1'];
                        $temp['mstate'] = $temp['state_1'];
                        $temp['mzip'] = $temp['zip_1'];
                    }
                } else {
                    $temp['maddress'] = $temp['address_1'];
                    $temp['mcity'] = $temp['city_1'];
                    $temp['mstate'] = $temp['state_1'];
                    $temp['mzip'] = $temp['zip_1'];
                }
            } else {

                if ($temp['mailingCheck'] == 'Y') {
                    $temp['maddress'] = $temp['address_2'];
                    $temp['mcity'] = $temp['city_2'];
                    $temp['mstate'] = $temp['state_2'];
                    $temp['mzip'] = $temp['zip_2'];
                } else {
                    $temp['maddress'] = $temp['address_3'];
                    $temp['mcity'] = $temp['city_3'];
                    $temp['mstate'] = $temp['state_3'];
                    $temp['mzip'] = $temp['zip_3'];
                }
            };

            // Retrieve Information From Encompass
            $response = Http::acceptJson()->withToken($access_token)->post(
                'https://api.elliemae.com/encompass/v1/loanPipeline',
                [
                    "filter" => [
                        "terms" => [
                            [
                                "canonicalName" => "Fields.364",
                                "value" => $item->PACLOAN,
                                "matchType" => "exact"
                            ],
                        ]
                    ]
                ]
            );
            $decoded = json_decode($response->body(), false);
            $loanGuid = $decoded[0]->loanGuid;
            $response = Http::acceptJson()->withToken($access_token)->post(
                'https://api.elliemae.com/encompass/v1/loans/' . $loanGuid . '/fieldReader',
                [
                    "SERVICE.X1",
                    "SERVICE.X2",
                    "SERVICE.X3",
                    "SERVICE.X4",
                    "SERVICE.X5",
                    "SERVICE.X6",
                    "SERVICE.X7",
                    "SERVICE.X13",
                    "SERVICE.X14",
                    "SERVICE.X15",
                    "SERVICE.X20",
                    "SERVICE.X24",
                    "SERVICE.X25",
                    "SERVICE.X26",
                    "SERVICE.X32",
                    "SERVICE.X33",
                    "SERVICE.X34",
                    "SERVICE.X35",
                    "SERVICE.X36",
                    "SERVICE.X37",
                    "SERVICE.X42",
                    "SERVICE.X44",
                    "SERVICE.X57",
                    "SERVICE.X77",
                    "SERVICE.X81",
                    "SERVICE.X82",
                    "674",
                    "672",
                    "3",
                    "11",
                    "12",
                    "14",
                    "15",
                    "68",
                    "69"
                ]
            );

            $decoded = json_decode($response->body(), true);
            foreach ($decoded as $item) {
                $loans[$count][$item['fieldId']] = $item['value'];
            }

            // Replace Loan Number
            $loans[$count]['SERVICE.X1'] = $temp['loanNumber'];

            // Replace Statement Date
            $loans[$count]['SERVICE.X13'] = $temp['statementDate'];

            // Replace Payment Due Date
            $loans[$count]['SERVICE.X14'] = $temp['paymentDue'];

            // Replace Escrow Payment
            $loans[$count]['SERVICE.X20'] = $temp['impound'];

            // Replace Princiapl And Interest
            $loans[$count]['SERVICE.X82'] = $temp['principalInterest'];

            // Replace Monthly Premium
            $loans[$count]['SERVICE.X77'] = !empty($temp['monthlyPremium']) ? $temp['monthlyPremium'] : "";

            // Replace Amount Due
            $loans[$count]['SERVICE.X24'] = !empty($loans[$count]['SERVICE.X24']) ? $loans[$count]['SERVICE.X24'] : $temp['total'];

            // LateFee Recalculation
            $loans[$count]['SERVICE.X25'] = round(floatval(str_replace(",", "", $loans[$count]['SERVICE.X24'])) * $loans[$count]['674'] / 100, 2);

            // LateDate Recalculation 
            $loans[$count]['SERVICE.X15'] = date('m/d/Y', (strtotime($loans[$count]['SERVICE.X14']) + (($loans[$count]['672'] - 1) * 3600 * 24)));

            // Total Amount with LateFee Recalculation
            $loans[$count]['SERVICE.X26'] = number_format(round(floatval(str_replace(",", "", $loans[$count]['SERVICE.X24'])) + floatval(str_replace(",", "", $loans[$count]['SERVICE.X25'])), 2), 2);

            // Principle Balance Recalculation when Principle Balance = $0
            // $principalBalance = number_format(round(floatval(str_replace(",", "", $result["SERVICE.X144"])) - floatval(str_replace(",", "", $result["SERVICE.X42"])), 2), 2);


            // Replace Borrower Mailing Address Information
            //first name
            $loans[$count]['SERVICE.X2'] = !empty($loans[$count]['SERIVCE.X2']) ? $loans[$count]['SERVICE.X2'] : $temp['firstName'];
            //last name
            $loans[$count]['SERVICE.X3'] = !empty($loans[$count]['SERIVCE.X3']) ? $loans[$count]['SERVICE.X3'] : $temp['lastName'];
            //Address
            $loans[$count]['SERVICE.X4'] = !empty($loans[$count]['SERIVCE.X4']) ? $loans[$count]['SERVICE.X4'] : $temp['maddress'];
            //City
            $loans[$count]['SERVICE.X5'] = !empty($loans[$count]['SERIVCE.X5']) ? $loans[$count]['SERVICE.X5'] : $temp['mcity'];
            //State
            $loans[$count]['SERVICE.X6'] = !empty($loans[$count]['SERIVCE.X6']) ? $loans[$count]['SERVICE.X6'] : $temp['mstate'];
            //ZIP
            $loans[$count]['SERVICE.X7'] = !empty($loans[$count]['SERIVCE.X7']) ? $loans[$count]['SERVICE.X7'] : $temp['mzip'];


            // Add $ symbol
            $loans[$count]['SERVICE.X20'] = !empty($loans[$count]['SERVICE.X20']) ? ('$' . $loans[$count]['SERVICE.X20']) : '-';
            $loans[$count]['SERVICE.X24'] = !empty($loans[$count]['SERVICE.X24']) ? ('$' . $loans[$count]['SERVICE.X24']) : '-';
            $loans[$count]['SERVICE.X25'] = !empty($loans[$count]['SERVICE.X25']) ? ('$' . $loans[$count]['SERVICE.X25']) : '-';
            $loans[$count]['SERVICE.X26'] = !empty($loans[$count]['SERVICE.X26']) ? ('$' . $loans[$count]['SERVICE.X26']) : '-';
            $loans[$count]['SERVICE.X33'] = !empty($loans[$count]['SERVICE.X33']) ? ('$' . $loans[$count]['SERVICE.X33']) : '-';
            $loans[$count]['SERVICE.X34'] = !empty($loans[$count]['SERVICE.X34']) ? ('$' . $loans[$count]['SERVICE.X34']) : '-';
            $loans[$count]['SERVICE.X35'] = !empty($loans[$count]['SERVICE.X35']) ? ('$' . $loans[$count]['SERVICE.X35']) : '-';
            $loans[$count]['SERVICE.X36'] = !empty($loans[$count]['SERVICE.X36']) ? ('$' . $loans[$count]['SERVICE.X36']) : '-';
            $loans[$count]['SERVICE.X37'] = !empty($loans[$count]['SERVICE.X37']) ? ('$' . $loans[$count]['SERVICE.X37']) : '-';
            $loans[$count]['SERVICE.X42'] = !empty($loans[$count]['SERVICE.X42']) ? ('$' . $loans[$count]['SERVICE.X42']) : '-';
            $loans[$count]['SERVICE.X44'] = !empty($loans[$count]['SERVICE.X44']) ? ('$' . $loans[$count]['SERVICE.X44']) : '-';
            $loans[$count]['SERVICE.X57'] = !empty($loans[$count]['SERVICE.X57']) ? ('$' . $loans[$count]['SERVICE.X57']) : '-';
            $loans[$count]['SERVICE.X77'] = !empty($loans[$count]['SERVICE.X77']) ? ('$' . $loans[$count]['SERVICE.X77']) : '-';
            $loans[$count]['SERVICE.X81'] = !empty($loans[$count]['SERVICE.X81']) ? ('$' . $loans[$count]['SERVICE.X81']) : '-';
            $loans[$count]['SERVICE.X82'] = !empty($loans[$count]['SERVICE.X82']) ? ('$' . $loans[$count]['SERVICE.X82']) : '-';
        }

        dd($loans);
        // return view('paymentletter.index', compact('loans'));
    }
}
