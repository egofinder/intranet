@extends('layouts.master')

@section('content')
    <div>
        <table>
            <thead>
                <tr>
                    <th class="table-auto border-2 border-solid border-sky-500">customer_account_key</th>
                    <th class="table-auto border-2 border-solid border-sky-500">collateral_key</th>
                    <th class="table-auto border-2 border-solid border-sky-500">pool_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">product_code</th>
                    <th class="table-auto border-2 border-solid border-sky-500">loan_type</th>
                    <th class="table-auto border-2 border-solid border-sky-500">loan_program</th>
                    <th class="table-auto border-2 border-solid border-sky-500">purpose_code</th>
                    <th class="table-auto border-2 border-solid border-sky-500">occupancy_code</th>
                    <th class="table-auto border-2 border-solid border-sky-500">doc_level_code</th>
                    <th class="table-auto border-2 border-solid border-sky-500">is_assets_verified</th>
                    <th class="table-auto border-2 border-solid border-sky-500">property_type_code</th>
                    <th class="table-auto border-2 border-solid border-sky-500">units</th>
                    <th class="table-auto border-2 border-solid border-sky-500">address</th>
                    <th class="table-auto border-2 border-solid border-sky-500">city</th>
                    <th class="table-auto border-2 border-solid border-sky-500">state</th>
                    <th class="table-auto border-2 border-solid border-sky-500">zip</th>
                    <th class="table-auto border-2 border-solid border-sky-500">orig_upb</th>
                    <th class="table-auto border-2 border-solid border-sky-500">curr_upb</th>
                    <th class="table-auto border-2 border-solid border-sky-500">purchase_price</th>
                    <th class="table-auto border-2 border-solid border-sky-500">lien_position</th>
                    <th class="table-auto border-2 border-solid border-sky-500">sr_lien_amount</th>
                    <th class="table-auto border-2 border-solid border-sky-500">jr_lien_amount</th>
                    <th class="table-auto border-2 border-solid border-sky-500">orig_appraised_value</th>
                    <th class="table-auto border-2 border-solid border-sky-500">appraiser_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">latest_bpo</th>
                    <th class="table-auto border-2 border-solid border-sky-500">latest_bpo_dt</th>
                    <th class="table-auto border-2 border-solid border-sky-500">original_ltv</th>
                    <th class="table-auto border-2 border-solid border-sky-500">original_cltv</th>
                    <th class="table-auto border-2 border-solid border-sky-500">curr_ltv</th>
                    <th class="table-auto border-2 border-solid border-sky-500">curr_cltv</th>
                    <th class="table-auto border-2 border-solid border-sky-500">orig_p_i</th>
                    <th class="table-auto border-2 border-solid border-sky-500">is_escrow_required</th>
                    <th class="table-auto border-2 border-solid border-sky-500">escrow_adv_bal</th>
                    <th class="table-auto border-2 border-solid border-sky-500">corp_adv_bal</th>
                    <th class="table-auto border-2 border-solid border-sky-500">origination_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">firstdue</th>
                    <th class="table-auto border-2 border-solid border-sky-500">paid_to_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">maturity</th>
                    <th class="table-auto border-2 border-solid border-sky-500">original_term</th>
                    <th class="table-auto border-2 border-solid border-sky-500">amortization_term</th>
                    <th class="table-auto border-2 border-solid border-sky-500">is_balloon</th>
                    <th class="table-auto border-2 border-solid border-sky-500">interest_only_period</th>
                    <th class="table-auto border-2 border-solid border-sky-500">interest_only_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">orig_rate</th>
                    <th class="table-auto border-2 border-solid border-sky-500">cur_note_rate</th>
                    <th class="table-auto border-2 border-solid border-sky-500">servicing_fee</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mtg_ins_pct</th>
                    <th class="table-auto border-2 border-solid border-sky-500">gfee</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mtg_ins_company</th>
                    <th class="table-auto border-2 border-solid border-sky-500">is_lpmi</th>
                    <th class="table-auto border-2 border-solid border-sky-500">lpmi_pct</th>
                    <th class="table-auto border-2 border-solid border-sky-500">fico_score</th>
                    <th class="table-auto border-2 border-solid border-sky-500">fico_updated</th>
                    <th class="table-auto border-2 border-solid border-sky-500">fico_date_updated</th>
                    <th class="table-auto border-2 border-solid border-sky-500">dti_ratio_frontend</th>
                    <th class="table-auto border-2 border-solid border-sky-500">dti_ratio_backend</th>
                    <th class="table-auto border-2 border-solid border-sky-500">is_first_time_buyer</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_1_last_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_1_first_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">ss_number</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_2_last_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_2_first_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">ss_number_2</th>
                    <th class="table-auto border-2 border-solid border-sky-500">citizenship_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_1_employ_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_2_employ_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_1_marital_status</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_2_marital_status</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_1_age</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_2_age</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_1_gender</th>
                    <th class="table-auto border-2 border-solid border-sky-500">borr_2_gender</th>
                    <th class="table-auto border-2 border-solid border-sky-500">is_adjustable</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armteaser</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armmargin</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armlfloor</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armindex</th>
                    <th class="table-auto border-2 border-solid border-sky-500">anncap_init</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armpcap</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armpfloor</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armlcap</th>
                    <th class="table-auto border-2 border-solid border-sky-500">first_rate_adjust_period
                    <th class="table-auto border-2 border-solid border-sky-500">rate_change_frequency</th>
                    <th class="table-auto border-2 border-solid border-sky-500">look_back_period</th>
                    <th class="table-auto border-2 border-solid border-sky-500">armoption</th>
                    <th class="table-auto border-2 border-solid border-sky-500">teaser_period</th>
                    <th class="table-auto border-2 border-solid border-sky-500">is_negam</th>
                    <th class="table-auto border-2 border-solid border-sky-500">max_negam</th>
                    <th class="table-auto border-2 border-solid border-sky-500">initial_recast_period</th>
                    <th class="table-auto border-2 border-solid border-sky-500">subsequent_recast_period
                    <th class="table-auto border-2 border-solid border-sky-500">heloc_ind</th>
                    <th class="table-auto border-2 border-solid border-sky-500">orig_line_amt</th>
                    <th class="table-auto border-2 border-solid border-sky-500">curr_line_amt</th>
                    <th class="table-auto border-2 border-solid border-sky-500">originator</th>
                    <th class="table-auto border-2 border-solid border-sky-500">servicer</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mers_min</th>
                    <th class="table-auto border-2 border-solid border-sky-500">fha_case_number</th>
                    <th class="table-auto border-2 border-solid border-sky-500">channel</th>
                    <th class="table-auto border-2 border-solid border-sky-500">qualified_mortgage</th>
                    <th class="table-auto border-2 border-solid border-sky-500">investor_code</th>
                    <th class="table-auto border-2 border-solid border-sky-500">inv_commit_number</th>
                    <th class="table-auto border-2 border-solid border-sky-500">inv_commit_price</th>
                    <th class="table-auto border-2 border-solid border-sky-500">inv_commit_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">inv_commit_expire_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">investor_loan_id</th>
                    <th class="table-auto border-2 border-solid border-sky-500">first_delinquent_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">times_delinquent_30</th>
                    <th class="table-auto border-2 border-solid border-sky-500">times_delinquent_60</th>
                    <th class="table-auto border-2 border-solid border-sky-500">times_delinquent_90</th>
                    <th class="table-auto border-2 border-solid border-sky-500">times_delinquent_120</th>
                    <th class="table-auto border-2 border-solid border-sky-500">delq_string</th>
                    <th class="table-auto border-2 border-solid border-sky-500">fc_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">bk_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">bankruptcy_chapter</th>
                    <th class="table-auto border-2 border-solid border-sky-500">reo_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">reo_evict_status</th>
                    <th class="table-auto border-2 border-solid border-sky-500">fc_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">bk_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">bk_discharge_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">foreclosure_satisfied_dat
                    <th class="table-auto border-2 border-solid border-sky-500">reo_activation_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mod_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mod_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mod_type</th>
                    <th class="table-auto border-2 border-solid border-sky-500">deferred_bal</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mod_detail</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mod_term</th>
                    <th class="table-auto border-2 border-solid border-sky-500">mod_aterm</th>
                    <th class="table-auto border-2 border-solid border-sky-500">step_rate</th>
                    <th class="table-auto border-2 border-solid border-sky-500">step_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">hamp_eligible_flag</th>
                    <th class="table-auto border-2 border-solid border-sky-500">loanprice</th>
                    <th class="table-auto border-2 border-solid border-sky-500">advance_amt</th>
                    <th class="table-auto border-2 border-solid border-sky-500">funding_amount</th>
                    <th class="table-auto border-2 border-solid border-sky-500">effective_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">funding_method_code</th>
                    <th class="table-auto border-2 border-solid border-sky-500">funding_id</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_address</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_city</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_state</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_zip</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_accountnum</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_abanum</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_instruction1</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee1_instruction2</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_address</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_city</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_state</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_zip</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_accountnum</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_abanum</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_instruction1</th>
                    <th class="table-auto border-2 border-solid border-sky-500">payee2_instruction2</th>
                    <th class="table-auto border-2 border-solid border-sky-500">funding_batch</th>
                    <th class="table-auto border-2 border-solid border-sky-500">effective_time</th>
                    <th class="table-auto border-2 border-solid border-sky-500">acquisition_price</th>
                    <th class="table-auto border-2 border-solid border-sky-500">acquisition_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">rehab_holdback_amount</th>
                    <th class="table-auto border-2 border-solid border-sky-500">rehab_BPO</th>
                    <th class="table-auto border-2 border-solid border-sky-500">total_rehab_budget</th>
                    <th class="table-auto border-2 border-solid border-sky-500">property_purchase_date</th>
                    <th class="table-auto border-2 border-solid border-sky-500">certificated_collateral</th>
                    <th class="table-auto border-2 border-solid border-sky-500">certificate_name</th>
                    <th class="table-auto border-2 border-solid border-sky-500">certificate_cusip</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table-auto border-2 border-solid border-red-500">PACB</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['loanNumber'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">NAGY30F</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1172'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1401'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        {{ ProcessingPurposeCode($result['19']) }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        {{ ProcessingOccupancyCode($result['1811']) }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        {{ ProcessingDocLevelCode($result['MORNET.X67']) }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        {{ ProcessingPropertyTypeCode($result['1041'], $result['16']) }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['16'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['11'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['12'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['14'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['15'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['2'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['2'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['136'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['CX.FUNDLIEN'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['356'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['353'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['976'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['CD1.X9'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['745']) }}
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['682']) }}
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['2397']) }}
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['78']) }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1347'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['325'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1659'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1177'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['2982'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['3'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['3'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['67'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['740'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['742'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['934'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['4002'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['4000'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['65'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['4006'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['4004'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['97'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        {{ ProcessingCitizenshipFlag($result['URLA.X1']) }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['52'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['84'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['38'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['70'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['689'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1699'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['696'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500">N</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1612'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['VEND.X178'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1051'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1040'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ ProcessingChannel($result['3332']) }}
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">NO</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500">0</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">N</td>
                    <td class="table-auto border-2 border-solid border-red-500">N</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1990'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['1990'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['1994']) }}
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">1</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['610'] }}
                        @else
                            {{ $result['411'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['612'] }}
                        @else
                            {{ $result['412'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['613'] }}
                        @else
                            {{ $result['413'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['1175'] }}
                        @else
                            {{ $result['1174'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['614'] }}
                        @else
                            {{ $result['414'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['VEND.X397'] }}
                        @else
                            {{ $result['VEND.X399'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['VEND.X396'] }}
                        @else
                            {{ $result['VEND.X398'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">
                        @if ($result['2001'] == 1)
                            {{ $result['2004'] }}
                        @else
                            {{ $result['2007'] }}
                        @endif
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ $result['22'] }}</td>
                    <td class="table-auto border-2 border-solid border-red-500">{{ DateConversion($result['L770']) }}
                    </td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500">N</td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                    <td class="table-auto border-2 border-solid border-red-500"></td>
                </tr>
            </tbody>
        </table>

        <form action="{{ $result['loanNumber'] . '/download' }}" id=form>
        </form>
        <button class="rounded-full bg-blue-500 py-2 px-4 font-bold text-white hover:bg-blue-700" form="form">
            Download
        </button>
    </div>
@endsection
