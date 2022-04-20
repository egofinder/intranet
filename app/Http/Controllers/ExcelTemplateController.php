<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelTemplateExport;

use App\Models\Token;

class ExcelTemplateController extends Controller
{
    public function csFunding($loanNumber)
    {
        $access_token = Token::find(1)->access_token;
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loanPipeline',
            [
                "filter" => [
                    "terms" => [
                        [
                            "canonicalName" => "Fields.364",
                            "value" => $loanNumber,
                            "matchType" => "exact"
                        ],
                    ]
                ]
            ]
        );
        $decoded = json_decode($response->body(), true);
        $sample = collect($decoded);
        $loanGuid = $sample[0]['loanGuid'];
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loans/' . $loanGuid . '/fieldReader',
            [
                "1172", "1401", "19", "1811", "MORNET.X67", "1041", "16", "11", "12", "14", "15", "2", "136", "CX.FUNDLIEN", "356", "353", "976",
                "CD1.X9", "745", "682", "2397", "78", "1347", "325", "1659", "1177", "2982", "3", "67", "740", "742", "934", "4002", "4000", "65", "4006", "4004", "97",
                "URLA.X1", "52", "84", "38", "70", "689", "1699", "696", "1612", "VEND.X178", "1051", "1040", "3332", "1990", "1994", "2001", "610", "612", "613", "1175", "614",
                "VEND.X397", "VEND.X396", "2004", "411", "412", "413", "1174", "414", "VEND.X399", "VEND.X398", "22", "L770", "2007"
            ]
        );

        $decoded = json_decode($response->body(), true);
        $result = array("loanNumber" => $loanNumber);

        foreach ($decoded as $item) {
            $result[$item['fieldId']] = $item['value'];
        }

        return view('exceltemplates.csfunding', compact('result'));
    }

    public function csFundingDownload($loanNumber)
    {
        $access_token = Token::find(1)->access_token;
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loanPipeline',
            [
                "filter" => [
                    "terms" => [
                        [
                            "canonicalName" => "Fields.364",
                            "value" => $loanNumber,
                            "matchType" => "exact"
                        ],
                    ]
                ]
            ]
        );
        $decoded = json_decode($response->body(), true);
        $sample = collect($decoded);
        $loanGuid = $sample[0]['loanGuid'];
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loans/' . $loanGuid . '/fieldReader',
            [
                "1172", "1401", "19", "1811", "MORNET.X67", "1041", "16", "11", "12", "14", "15", "2", "136", "CX.FUNDLIEN", "356", "353", "976",
                "CD1.X9", "745", "682", "2397", "78", "1347", "325", "1659", "1177", "2982", "3", "67", "740", "742", "934", "4002", "4000", "65", "4006", "4004", "97",
                "URLA.X1", "52", "84", "38", "70", "689", "1699", "696", "1612", "VEND.X178", "1051", "1040", "3332", "1990", "1994", "2001", "610", "612", "613", "1175", "614",
                "VEND.X397", "VEND.X396", "2004", "411", "412", "413", "1174", "414", "VEND.X399", "VEND.X398", "22", "L770", "2007"
            ]
        );

        $decoded = json_decode($response->body(), true);
        $result = array("loanNumber" => $loanNumber);

        foreach ($decoded as $item) {
            $result[$item['fieldId']] = $item['value'];
        };

        $data = new ExcelTemplateExport([
            [
                "customer_account_key",
                "collateral_key",
                "pool_name",
                "product_code",
                "loan_type",
                "loan_program",
                "purpose_code",
                "occupancy_code",
                "doc_level_code",
                "is_assets_verified",
                "property_type_code",
                "units",
                "address",
                "city",
                "state",
                "zip",
                "orig_upb",
                "curr_upb",
                "purchase_price",
                "lien_position",
                "sr_lien_amount",
                "jr_lien_amount",
                "orig_appraised_value",
                "appraiser_name",
                "latest_bpo",
                "latest_bpo_dt",
                "original_ltv",
                "original_cltv",
                "curr_ltv",
                "curr_cltv",
                "orig_p_i",
                "is_escrow_required",
                "escrow_adv_bal",
                "corp_adv_bal",
                "origination_date",
                "firstdue",
                "paid_to_date",
                "maturity",
                "original_term",
                "amortization_term",
                "is_balloon",
                "interest_only_period",
                "interest_only_flag",
                "orig_rate",
                "cur_note_rate",
                "servicing_fee",
                "mtg_ins_pct",
                "gfee",
                "mtg_ins_company",
                "is_lpmi",
                "lpmi_pct",
                "fico_score",
                "fico_updated",
                "fico_date_updated",
                "dti_ratio_frontend",
                "dti_ratio_backend",
                "is_first_time_buyer",
                "borr_1_last_name",
                "borr_1_first_name",
                "ss_number",
                "borr_2_last_name",
                "borr_2_first_name",
                "ss_number_2",
                "citizenship_flag",
                "borr_1_employ_flag",
                "borr_2_employ_flag",
                "borr_1_marital_status",
                "borr_2_marital_status",
                "borr_1_age",
                "borr_2_age",
                "borr_1_gender",
                "borr_2_gender",
                "is_adjustable",
                "armteaser",
                "armmargin",
                "armlfloor",
                "armindex",
                "anncap_init",
                "armpcap",
                "armpfloor",
                "armlcap",
                "first_rate_adjust_period",
                "rate_change_frequency",
                "look_back_period",
                "armoption",
                "teaser_period",
                "is_negam",
                "max_negam",
                "initial_recast_period",
                "subsequent_recast_period",
                "heloc_ind",
                "orig_line_amt",
                "curr_line_amt",
                "originator",
                "servicer",
                "mers_min",
                "fha_case_number",
                "channel",
                "qualified_mortgage",
                "investor_code",
                "inv_commit_number",
                "inv_commit_price",
                "inv_commit_date",
                "inv_commit_expire_date",
                "investor_loan_id",
                "first_delinquent_date",
                "times_delinquent_30",
                "times_delinquent_60",
                "times_delinquent_90",
                "times_delinquent_120",
                "delq_string",
                "fc_flag",
                "bk_flag",
                "bankruptcy_chapter",
                "reo_flag",
                "reo_evict_status",
                "fc_date",
                "bk_date",
                "bk_discharge_date",
                "foreclosure_satisfied_date",
                "reo_activation_date",
                "mod_flag",
                "mod_date",
                "mod_type",
                "deferred_bal",
                "mod_detail",
                "mod_term",
                "mod_aterm",
                "step_rate",
                "step_date",
                "hamp_eligible_flag",
                "loanprice",
                "advance_amt",
                "funding_amount",
                "effective_date",
                "funding_method_code",
                "funding_id",
                "payee1_name",
                "payee1_address",
                "payee1_city",
                "payee1_state",
                "payee1_zip",
                "payee1_accountnum",
                "payee1_abanum",
                "payee1_instruction1",
                "payee1_instruction2",
                "payee2_name",
                "payee2_address",
                "payee2_city",
                "payee2_state",
                "payee2_zip",
                "payee2_accountnum",
                "payee2_abanum",
                "payee2_instruction1",
                "payee2_instruction2",
                "funding_batch",
                "effective_time",
                "acquisition_price",
                "acquisition_date",
                "rehab_holdback_amount",
                "rehab_BPO",
                "total_rehab_budget",
                "property_purchase_date",
                "certificated_collateral",
                "certificate_name",
                "certificate_cusip",
            ],
            [
                "PACB",
                $result['loanNumber'],
                "",
                "NAGY30F",
                $result['1172'],
                $result['1401'],
                ProcessingPurposeCode($result['19']),
                ProcessingOccupancyCode($result['1811']),
                ProcessingDocLevelCode($result['MORNET.X67']),
                "",
                ProcessingPropertyTypeCode($result['1041'], $result['16']),
                $result['16'],
                $result['11'],
                $result['12'],
                $result['14'],
                $result['15'],
                $result['2'],
                $result['2'],
                $result['136'],
                $result['CX.FUNDLIEN'],
                "",
                "",
                $result['356'],
                "",
                "",
                "",
                $result['353'],
                $result['976'],
                "",
                "",
                $result['CD1.X9'],
                "",
                "",
                "",
                DateConversion($result['745']),
                DateConversion($result['682']),
                DateConversion($result['2397']),
                DateConversion($result['78']),
                $result['1347'],
                $result['325'],
                $result['1659'],
                $result['1177'],
                $result['2982'],
                $result['3'],
                $result['3'],
                "",
                "",
                "",
                "",
                "",
                "",
                $result['67'],
                "",
                "",
                $result['740'],
                $result['742'],
                $result['934'],
                $result['4002'],
                $result['4000'],
                $result['65'],
                $result['4006'],
                $result['4004'],
                $result['97'],
                ProcessingCitizenshipFlag($result['URLA.X1']),
                "",
                "",
                $result['52'],
                $result['84'],
                $result['38'],
                $result['70'],
                "",
                "",
                "",
                "",
                $result['689'],
                $result['1699'],
                "",
                "",
                "",
                "0",
                "0",
                $result['696'],
                "0",
                "0",
                "N",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                $result['1612'],
                $result['VEND.X178'],
                $result['1051'],
                $result['1040'],
                ProcessingChannel($result['3332']),
                "NO",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "0",
                "0",
                "0",
                "0",
                "",
                "N",
                "N",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                $result['1990'],
                $result['1990'],
                DateConversion($result['1994']),
                "1",
                "",
                ($result['2001'] == 1) ? $result['610'] : $result['411'],
                ($result['2001'] == 1) ? $result['612'] : $result['412'],
                ($result['2001'] == 1) ? $result['613'] : $result['413'],
                ($result['2001'] == 1) ? $result['1175'] : $result['1174'],
                ($result['2001'] == 1) ? $result['614'] : $result['414'],
                ($result['2001'] == 1) ? $result['VEND.X397'] : $result['VEND.X399'],
                ($result['2001'] == 1) ? $result['VEND.X396'] : $result['VEND.X398'],
                "",
                ($result['2001'] == 1) ? $result['2004'] : $result['2007'],
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                $result['22'],
                DateConversion($result['L770']),
                "",
                "",
                "",
                "",
                "N",
                "",
                ""
            ]
        ]);
        return Excel::download($data, 'CSFunding.xlsx');
    }


    public function vistaPoint($loanNumber)
    {
        $access_token = Token::find(1)->access_token;
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loanPipeline',
            [
                "filter" => [
                    "terms" => [
                        [
                            "canonicalName" => "Fields.364",
                            "value" => $loanNumber,
                            "matchType" => "exact"
                        ],
                    ]
                ]
            ]
        );
        $decoded = json_decode($response->body(), true);
        $sample = collect($decoded);
        $loanGuid = $sample[0]['loanGuid'];
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loans/' . $loanGuid . '/fieldReader',
            [
                "364", "1401", "4000", "4002", "2", "3", "353", "976", "1484", "273", "FE0115", "FE0215", "1502", "911", "4004", "4006", "1811", "384", "L206R", "742", "2867",
                "1177", "HMDA.X82", "RE88395.X322", "11", "12", "14", "15", "356", "136", "URLA.X102", "URLA.X103", "1041", "16", "2962", "608", "689", "688", "695", "247", "1699",
                "325", "696", "1347", "3925", "682", "3514", "2", "HMDA.X26", "HMDA.X26", "LoanTeamMember.Email.TPO Loan Officer", "VEND.X200", "HMDA.X28"
            ]
        );

        $decoded = json_decode($response->body(), true);
        $result = array("loanNumber" => $loanNumber);

        foreach ($decoded as $item) {
            $result[$item['fieldId']] = $item['value'];
        }

        return view('exceltemplates.vistapoint', compact('result'));
    }

    public function vistaPointDownload($loanNumber)
    {
        $access_token = Token::find(1)->access_token;
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loanPipeline',
            [
                "filter" => [
                    "terms" => [
                        [
                            "canonicalName" => "Fields.364",
                            "value" => $loanNumber,
                            "matchType" => "exact"
                        ],
                    ]
                ]
            ]
        );
        $decoded = json_decode($response->body(), true);
        $sample = collect($decoded);
        $loanGuid = $sample[0]['loanGuid'];
        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loans/' . $loanGuid . '/fieldReader',
            [
                "364", "1401", "4000", "4002", "2", "3", "353", "976", "1484", "273", "FE0115", "FE0215", "1502", "911", "4004", "4006", "1811", "384", "L206R", "742", "2867",
                "1177", "HMDA.X82", "RE88395.X322", "11", "12", "14", "15", "356", "136", "URLA.X102", "URLA.X103", "1041", "16", "2962", "608", "689", "688", "695", "247", "1699",
                "325", "696", "1347", "3925", "682", "3514", "2", "HMDA.X26", "HMDA.X26", "LoanTeamMember.Email.TPO Loan Officer", "VEND.X200", "HMDA.X28"
            ]
        );

        $decoded = json_decode($response->body(), true);
        $result = array("loanNumber" => $loanNumber);

        foreach ($decoded as $item) {
            $result[$item['fieldId']] = $item['value'];
        }

        $data = new ExcelTemplateExport([
            [
                "Loan Number",
                "Loan Program",
                "Borrower Last Name",
                "Borrower First Name",
                "Loan Amount",
                "Note Rate",
                "LTV",
                "Combined LTV",
                "Borrower minimum Fico",
                "Income Total Mo Income (Borr/Co-Borr)",
                "BORROWER SELF EMPLOYED",
                "CO-BORROWER SELF EMPLOYED",
                "Co-Borr Min Fico",
                "INCOME CO-BORR TOTAL INCOME",
                "Co-Borrower First Name",
                "Co-Borrower Last Name",
                "Occupancy (P/S/I)",
                "Loan Purpose",
                "Trans Details Cash From Borr",
                "Bottom Ratio",
                "LOCK REQUEST DOC TYPE",
                "Interest Only Mos",
                "Prepayment Penalty Period",
                "Prepay Penalty",
                "Subject Property Address",
                "Subject Property City",
                "Subject Property State",
                "Subject Property Zip",
                "Appraised Value",
                "Subject Property Purchase Price",
                "BORR DECLARATIONS J",
                "CO-BORR DECLARATIONS J",
                "SUBJECT PROPERTY TYPE",
                "Subject Property # Units",
                "Impound Types",
                "Amortization Type",
                "Margin",
                "Loan Info ARM Index",
                "LOAN INFO ARM RATE CAP",
                "Life Cap",
                "Floor Rate",
                "Term Due In",
                "Loan Info ARM First Period Change",
                "Loan Term",
                "Docs Sent",
                "First Pymt Date",
                "Servicing Payment Due Date",
                "Loan Amount",
                "QM Status",
                "Qualified Mortgage Status",
                "Loan Team Member Email - TPO LOAN OFFICER",
                "Warehouse Co Name",
                "Universal Loan Id",
                "Guidelines Used"
            ],
            [
                $result['364'],
                $result['1401'],
                $result['4000'],
                $result['4002'],
                $result['2'],
                $result['3'],
                $result['353'],
                $result['976'],
                $result['1484'],
                $result['273'],
                $result['FE0115'],
                $result['FE0215'],
                $result['1502'],
                $result['911'],
                $result['4004'],
                $result['4006'],
                $result['1811'],
                $result['384'],
                $result['L206R'],
                $result['742'],
                $result['2867'],
                $result['1177'],
                $result['HMDA.X82'],
                $result['RE88395.X322'],
                $result['11'],
                $result['12'],
                $result['14'],
                $result['15'],
                $result['356'],
                $result['136'],
                $result['URLA.X102'],
                $result['URLA.X103'],
                $result['1041'],
                $result['16'],
                $result['2962'],
                $result['608'],
                $result['689'],
                $result['688'],
                $result['695'],
                $result['247'],
                $result['1699'],
                $result['325'],
                $result['696'],
                $result['1347'],
                DateConversion($result['3925']),
                DateConversion($result['682']),
                $result['3514'],
                $result['2'],
                $result['HMDA.X26'],
                $result['HMDA.X26'],
                $result['LoanTeamMember.Email.TPO Loan Officer'],
                $result['VEND.X200'],
                $result['HMDA.X28'],
            ]
        ]);
        return Excel::download($data, 'VistaPoint.xlsx');
    }


    public function index()
    {
        return view('exceltemplates.index');
    }
}
