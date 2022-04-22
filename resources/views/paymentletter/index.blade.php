<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .ftsm {
            font-size: 15px;
            letter-spacing: -0.8px;
        }

        .ftbld {
            font-weight: 800;
        }

        .ftxsm {
            font-size: 14px;
        }

        .fttxsm {
            font-size: 13px;
        }

        @media print {
            .page-divide {
                page-break-after: always;
            }

            .no-print-page {
                display: none;
            }

            /* @page {
                margin: 0;

                body {
                    margin: 1.6cm;
                }
            } */
        }

    </style>
</head>

@foreach ($loans as $loan)

    <body>
        <table class="page-divide" border="0" style="width:816px; height:1054px;">
            <tbody>
                <tr style="vertical-align: top; height:10px;">
                    <td colspan="4">
                        <img src="{{ asset('storage/resources/images/bay_valley.png') }}"
                            style="width:70%; height:auto;" />
                        <div style="position:relative; top:-24px;" class="ftxsm">
                            Bay Valley Mortgage Group dba Valley View Home Loans dba Pacific Bay Lending Group
                        </div>
                    </td>
                </tr>
                <tr style="height: 10px;">
                    <td colspan="2" style="width: 50%;"></td>
                    <td style="padding-bottom: 10px;" colspan="2">
                        <div class="ftbld">
                            MORTGAGE LOAN STATEMENT
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>
                        <div class="ftbld ftsm">
                            Customer Service Phone:<br>
                            Send payments only to:
                        </div>
                    </td>
                    <td>
                        <div class="ftbld ftsm">
                            855-550-6500<br>
                            Bay Valley Mortgage Group<br>
                            7390 Lincoln Way<br>
                            Garden Grove, CA 92841
                        </div>
                    </td>
                    <td style="width:25%;">
                        <div class="ftbld ftsm">
                            Statement Date:<br>
                            Loan Number:
                        </div>
                    </td>
                    <td style="width:25%;">
                        <div class="ftbld ftsm">
                            <div>{{ $loan['SERVICE.X13'] }}</div>
                            <div>{{ $loan['SERVICE.X1'] }}</div>
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td colspan="2">

                    </td>
                    <td style="padding-bottom: 5px;" colspan="2">
                        <div class="ftbld ftxsm">
                            PROPERTY INFORMATION
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td colspan="2">
                        <div class="ftbld ftsm">
                            <div>
                                <span>{{ $loan['SERVICE.X2'] }}</span>
                                <span>{{ $loan['SERVICE.X3'] }}</span>
                            </div>
                            <div>
                                <span>{{ $loan['68'] }}</span>
                                <span>{{ $loan['69'] }}</span>
                            </div>
                            <div>{{ $loan['SERVICE.X4'] }}</div>
                            <div>
                                <span>{{ $loan['SERVICE.X5'] }}</span>
                                <span>, </span>
                                <span>{{ $loan['SERVICE.X6'] }}</span>
                                <span> </span>
                                <span>{{ $loan['SERVICE.X7'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="ftbld ftsm">
                            Address:
                        </div>
                    </td>
                    <td>
                        <div class="ftbld ftsm">
                            <div>{{ $loan['11'] }}</div>
                            <div>
                                <span>{{ $loan['12'] }}</span>
                                <span>, </span>
                                <span>{{ $loan['14'] }}</span>
                                <span> </span>
                                <span>{{ $loan['15'] }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td colspan="2"></td>
                    <td colspan="2">
                        <div class="ftbld ftxsm">
                            YEAR TO DATE SUMMARY
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td></td>
                    <td></td>
                    <td>
                        <div class="ftsm">
                            <div>
                                Principal Paid:<br>
                                Interest Paid:<br>
                            </div>
                            <div class="ftbld">
                                Principal Balance:<br>
                                Escrow Balance:
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="ftsm">
                            <div>
                                <div>{{ $loan['SERVICE.X42'] }}</div>
                                <div>{{ $loan['SERVICE.X44'] }}</div>
                            </div>
                            <div class="ftbld">
                                <div>{{ $loan['SERVICE.X57'] }}</div>
                                <div>{{ $loan['SERVICE.X81'] }}</div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>
                        <div class="ftbld ftxsm">
                            NEXT PAYMENT
                        </div>
                    </td>
                    <td></td>
                    <td>
                        <div class="ftbld ftxsm">
                            LAST PAYMENT
                        </div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>
                        <div class="ftsm">
                            Interest Rate:<br>
                            Payment Due:<br>
                            Principal and Interest:<br>
                            Impounds:<br>
                            MMI/PMI Monthly Premium:
                        </div>
                    </td>
                    <td>
                        <div class="ftsm">
                            <div>{{ $loan['3'] }}</div>
                            <div>{{ $loan['SERVICE.X14'] }}</div>
                            <div>{{ $loan['SERVICE.X82'] }}</div>
                            <div>{{ $loan['SERVICE.X20'] }}</div>
                            <div>{{ $loan['SERVICE.X77'] }}</div>

                        </div>
                    </td>
                    <td>
                        <div class="ftsm">
                            Date:<br>
                            Principal:<br>
                            Interest:<br>
                            Escrow:<br>
                            Late Fee:
                        </div>
                    </td>
                    <td>
                        <div class="ftsm">
                            <div>{{ $loan['SERVICE.X32'] }}</div>
                            <div>{{ $loan['SERVICE.X34'] }}</div>
                            <div>{{ $loan['SERVICE.X35'] }}</div>
                            <div>{{ $loan['SERVICE.X36'] }}</div>
                            <div>{{ $loan['SERVICE.X37'] }}</div>
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>
                        <div class="ftbld">
                            Total Amount Due:
                        </div>
                    </td>
                    <td>
                        <div class="ftbld">
                            <div>{{ $loan['SERVICE.X24'] }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="ftbld">
                            Total Amount Received:
                        </div>
                    </td>
                    <td>
                        <div class="ftbld">
                            <div>{{ $loan['SERVICE.X33'] }}</div>
                        </div>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td colspan="2">
                        <div class="ftbld fttxsm">
                            To avoid a late charge of <span>{{ $loan['SERVICE.X25'] }}</span>, we must receive your
                            payment of principal, interest, escrow and/or past-due payments
                            during our normal business hours before <span>{{ $loan['SERVICE.X15'] }}</span>.
                        </div>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center; font-weight: 800;">
                        <div class="ftbld">
                            Please detach and return the bottom portion of this statement with your payment
                        </div>
                        <br>
                        - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                        - -
                        - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">
                        <div class="ftbld" style="float:right; padding-right: 20px;">
                            Please allow up to 10 days for mailing
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="ftbld ftsm">
                            <div>
                                <span>{{ $loan['SERVICE.X2'] }}</span>
                                <span>{{ $loan['SERVICE.X3'] }}</span>
                            </div>
                            <div>
                                <span>{{ $loan['68'] }}</span>
                                <span>{{ $loan['69'] }}</span>
                            </div>
                            <div>
                                Loan Number: <span>{{ $loan['SERVICE.X1'] }}</span><br>
                                Statement Date: <span>{{ $loan['SERVICE.X13'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="ftbld ftsm">
                            Payment Due Date:<br>
                            Total Amount Due:<br>
                            If Received on or after:<br>
                            Total Amount with Late Fee: <br>
                        </div>
                    </td>
                    <td>
                        <div class="ftbld ftsm">
                            <div>{{ $loan['SERVICE.X14'] }}</div>
                            <div>{{ $loan['SERVICE.X24'] }}</div>
                            <div>{{ $loan['SERVICE.X15'] }}</div>
                            <div>{{ $loan['SERVICE.X26'] }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="ftbld fttxsm">
                            Please make your check or money order
                            payable to Bay Valley Mortgage Group
                            and write your loan number on it. <br>
                        </div>
                        <br>
                        <div class="ftbld fttxsm">
                            *ONLY accept personal checks,
                            cashier checks or money orders.
                        </div>
                        <br>
                        <div class="ftbld fttxsm">
                            We are unable to apply overpayments to the principal balance.
                            All payments over the Total Amount Due will be reimbursed.
                        </div>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">
                        <div class="ftbld">
                            Total Amount Enclosed: =_______________________
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="no-print-page">
            ============================================================================================
        </div>
    </body>
@endforeach


<script type="text/javascript">
    $(document).ready(function() {
        window.print();
        setTimeout(function() {
            window.location.href = 'http://192.168.1.174/payment_auto_list.php';
        }, 100);
    });
</script>

</html>
