<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\TeamsNotificationController;
use App\Models\Token;
use App\Http\Controllers\TokenController;


class GetLoanInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        TokenController::introspectToken();
        $access_token = Token::find(1)->access_token;
        $date = date('Y-m-d', strtotime('-3 years'));

        $response = Http::acceptJson()->withToken($access_token)->post(
            'https://api.elliemae.com/encompass/v1/loanPipeline?cursorType=randomAccess&limit=1',
            [
                "sortOrder" => [
                    [
                        "canonicalName" => "Loan.LoanNumber",
                        "order" => "asc"
                    ],
                ],
                "operator" => "and",
                "filter" => [
                    "terms" => [
                        [
                            "canonicalName" => "Fields.749",
                            // "value" => $date,
                            "value" => '2022-04-17',
                            "matchType" => "greaterThan"
                        ],
                        [
                            "canonicalName" => "Fields.CUST11FV",
                            "value" => "Application denied",
                            "matchType" => "notEquals"
                        ],
                        [
                            "canonicalName" => "Fields.CUST11FV",
                            "value" => "Application withdrawn",
                            "matchType" => "notEquals"
                        ]
                    ]
                ]
            ]
        );

        $loan_count = $response->header('X-Total-Count');
        $loan_cursor = $response->header('X-Cursor');
        $max_loop = ($loan_count - ($loan_count % 250)) / 250;

        Storage::disk('local')->delete(['encompass_report.txt', 'encompass_buyside.txt', 'subservicing_data.txt']);

        // Initialize File.
        $encompass_report =
            "TransDetailsApplicationDate" . "\t" .
            "PurchaseAdviceDate" . "\t" .
            "TransDetailsLoan" . "\t" .
            "BorrowerFirstName" . "\t" .
            "BorrowerLastName" . "\t" .
            "InvestorCaseLoan" . "\t" .
            "SubjectPropertyAddress" . "\t" .
            "SubjectPropertyCity" . "\t" .
            "SubjectPropertyState" . "\t" .
            "SubjectPropertyZip" . "\t" .
            "FileContactsInvestorName" . "\t" .
            "WarehouseCoName" . "\t" .
            "RateLockBuySideBasePriceRate" . "\t" .
            "BuySidePriceTotAdjustment" . "\t" .
            "NetBuyPrice" . "\t" .
            "NetSellRate" . "\t" .
            "BaseSellPrice" . "\t" .
            "SellSidePriceTotAdjustment" . "\t" .
            "RateLockSellSideNetSellPrice" . "\t" .
            "SellSideSRPPaidOut" . "\t" .
            "SellSideDiscountYSP" . "\t" .
            "RateLockSellSideInvestorDeliveryDate" . "\t" .
            "RateLockSellSideTargetDeliveryDate" . "\t" .
            "RateLockSellSideTotalSellPrice" . "\t" .
            "GainLossPercent" . "\t" .
            "GainLossAmount" . "\t" .
            "TotalLoanAmount" . "\t" .
            "TotalWireTransfer" . "\t" .
            "LoanStatus" . "\t" .
            "FundsSentDate" . "\t" .
            "ShippingDate" . "\t" .
            "Occupancy" . "\t" .
            "BorrPresentAddr" . "\t" .
            "BorrPresentCity" . "\t" .
            "BorrPresentState" . "\t" .
            "BorrPresentZip" . "\t" .
            "LastFinishedMilestone" . "\t" .
            "BorrEmail" . "\t" .
            "LoanType" . "\t" .
            "RateLockBuySideTotalBuyPrice" . "\t" .
            "RateLockSellSideBasePriceAdjust1Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust1Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust2Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust2Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust3Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust3Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust4Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust4Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust5Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust5Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust6Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust6Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust7Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust7Rate" . "\t" .
            "BrokerLenderName" . "\t" .
            "PIPaymentAmount" . "\t" .
            "MortgageInsuranceAmount" . "\t" .
            "EstimatedEscrowAmount" . "\t" .
            "BorrHomePhone" . "\t" .
            "Underwriter" . "\t" .
            "FirstPmtDate" . "\t" .
            "Shipper" . "\t" .
            "TeamMember" . "\t" .
            "SetUpDate" . "\t" .
            "LienPosition" . "\t" .
            "DocPrepDate" . "\t" .
            "DocDrawnBy" . "\t" .
            "ClearToCloseDate" . "\t" .
            "ClearForDocsDate" . "\t" .
            "UnitNumber" . "\t" .
            "FHACase" . "\t" .
            "SubjectPropertyPurchasePrice" . "\t" .
            "CountyName" . "\t" .
            "LoanPurpose" . "\t" .
            "MilestoneDate" . "\t" .
            "MilestoneDate2" . "\t" .
            "SubjectPropertyAppraisedValue" . "\t" .
            "BorrMailingAddr" . "\t" .
            "BorrMailingCity" . "\t" .
            "BorrMailingState" . "\t" .
            "BorrMailingZip" . "\t" .
            "BorrMailingCheck" . "\t" .
            "SubjectPropertyTypeFannieMae" . "\t" .
            "DocReturnDate" . "\t" .
            "TPOCompanyAEName" . "\t" .
            "SubjectPropertyCountyCode" . "\t" .
            "TPOCompanyName" . "\t" .
            "TPOCompanyAddress" . "\t" .
            "TPOCompanyAddressCity" . "\t" .
            "TPOCompanyAddressState" . "\t" .
            "TPOPhone" . "\t" .
            "LoanProgram" . "\t" .
            "FeeDetailesLine1102gSec32PointsAndFees" . "\t" .
            "BorrSSN" . "\t" .
            "LockExpireDate" . "\t" .
            "TPOEmail" . "\t" .
            "Channel" . "\t" .
            "TransDetailsInterestRate" . "\t" .
            "TransDetailsTerm" . "\t" .
            "FundingType" . "\t" .
            "DecisionDate" . "\t" .
            "FinalApprovalDate" . "\t" .
            "Fields.OrgID" . "\t" .
            "Fields.OrgIDMap" . "\t" .
            "LEDueDate" . "\t" .
            "LESentDate" . "\t" .
            "FileStarterEmail" . "\t" .
            "LoanOfficerEmail" . "\t" .
            "FileStarterName" . "\t" .
            "LoanOfficerName" . "\t" .
            "ProcessingDate" . "\t" .
            "PreApproveDate" . "\t" .
            "DocType" . "\t" .
            "DaysSetUp" . "\t" .
            "DaysPreApprove" . "\t" .
            "DaysDecision" . "\t" .
            "DaysPTD" . "\t" .
            "DaysClearDocs" . "\t" .
            "DaysDocPrep" . "\t" .
            "DaysDocReturn" . "\t" .
            "DaysFinalApprove" . "\t" .
            "DaysClosing" . "\t" .
            "DaysFunding" . "\t" .
            "DaysSuspense" . "\t" .
            "DaysPurchase" . "\t" .
            "PTDDate" . "\t" .
            "RateLockSellSideBasePriceAdjust8Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust8Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust9Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust9Rate" . "\t" .
            "RateLockSellSideBasePriceAdjust10Desc" . "\t" .
            "RateLockSellSideBasePriceAdjust10Rate" . "\t" .
            "AccountManager" . "\t" .
            "JrUnderwriter" . "\t" .
            "EscrowPaymentDate" . "\t" .
            "EscrowPaymentType" . "\t" .
            "EscrowPaymentName" . "\t" .
            "EscrowPaymentAmount" . "\t" .
            "Fees1000Total" . "\t" .
            "TPOAEBranchName" . "\t" .
            "CurrentStatusDate" . "\t" .
            "FundingDate" . "\t" .
            "APR" . "\t" .
            "LoanOfficerNMLS" . "\t" .
            "EscrowPaymentDate1" . "\t" .
            "DisbursementDate" . "\t" .
            "EscrowPaymentType1" . "\t" .
            "EscrowPaymentName1" . "\t" .
            "EscrowPaymentAmount1" . "\t" .
            "Funder" . "\t" .
            "DisclosureFullfilledBy" . "\t" .
            "DisclosureDateTimeSent" . "\t" .
            "EscrowPaymentDate2" . "\t" .
            "EscrowPaymentType2" . "\t" .
            "EscrowPaymentName2" . "\t" .
            "EscrowPaymentAmount2" . "\t" .
            "EscrowPaymentDate3" . "\t" .
            "EscrowPaymentType3" . "\t" .
            "EscrowPaymentName3" . "\t" .
            "EscrowPaymentAmount3" . "\t" .
            "EscrowPaymentDate4" . "\t" .
            "EscrowPaymentType4" . "\t" .
            "EscrowPaymentName4" . "\t" .
            "EscrowPaymentAmount4" . "\t" .
            "ShippingCoordinator" . "\t" .
            "SuspenseCoordinator" . "\t" .
            "QCShippingReadyBy" . "\t" .
            "QCShippingReadyDate" . "\t" .
            "ClosingPackageDate" . "\t" .
            "DisclosureConditionClearedBy" . "\t" .
            "DisclosureConditionClearedDate" . "\t" .
            "EstimatedEscrow1" . "\n";

        $encompass_buyside =
            "LoanNumber" . "\t" .
            "CoBorrowerFirstName" . "\t" .
            "CoBorrowerLastName" . "\t" .
            "SubjectPropertyType" . "\t" .
            "LTV" . "\t" .
            "CombinedLTV" . "\t" .
            "NoteRate" . "\t" .
            "LienPosition" . "\t" .
            "LoanType" . "\t" .
            "LoanTerm" . "\t" .
            "LoanPurpose" . "\t" .
            "Occupancy" . "\t" .
            "TopRatio" . "\t" .
            "BottomRatio" . "\t" .
            "LoanProgram" . "\t" .
            "LockDate" . "\t" .
            "RateLockDays" . "\t" .
            "LockExpirationDate" . "\t" .
            "VALoanSummCreditScore" . "\t" .
            "ImpoundsWaived" . "\t" .
            "ImpoundTypes" . "\t" .
            "UnderwritingRiskAssessAUSRecomm" . "\t" .
            "BuySideBaseRate" . "\t" .
            "RateLockBuySideBaseRateAdjust1Desc" . "\t" .
            "RateLockBuySideBaseRateAdjust1Rate" . "\t" .
            "RateLockBuySideBaseRateAdjust2Desc" . "\t" .
            "RateLockBuySideBaseRateAdjust2Rate" . "\t" .
            "RateLockBuySideBaseRateAdjust3Desc" . "\t" .
            "RateLockBuySideBaseRateAdjust3Rate" . "\t" .
            "BuySideRateTotAdjustment" . "\t" .
            "RateLockBuysideNetBuyRate" . "\t" .
            "BuySideBasePrice" . "\t" .
            "RateLockBuySideBasePriceAdjustment1Desc" . "\t" .
            "RateLockBuySideBasePriceAdjustment1Rate" . "\t" .
            "RateLockBuySideBasePriceAdjustment2Desc" . "\t" .
            "RateLockBuySideBasePriceAdjustment2Rate" . "\t" .
            "RateLockBuySideBasePriceAdjustment3Desc" . "\t" .
            "RateLockBuySideBasePriceAdjustment3Rate" . "\t" .
            "RateLockBuySideBasePriceAdjustment4Desc" . "\t" .
            "RateLockBuySideBasePriceAdjustment4Rate" . "\t" .
            "RateLockBuySideBasePriceAdjustment5Desc" . "\t" .
            "RateLockBuySideBasePriceAdjustment5Rate" . "\t" .
            "BuySidePriceTotAdjustment" . "\t" .
            "NetBuyPrice" . "\t" .
            "FirstRateAdjustmentCap" . "\t" .
            "LoanInfoARMFirstPeriodChange" . "\t" .
            "LoanInfoARMRateCap" . "\t" .
            "LifeCap" . "\t" .
            "LoanInfoARMIndex" . "\t" .
            "Margin" . "\t" .
            "LoanInfoARMMaxLifeInterestCap" . "\t" .
            "FloorRate" . "\t" .
            "FeesLoanOriginationFeeBorr" . "\t" .
            "FeesLine801BrokerCompensationBorrowerPaid" . "\t" .
            "FeesMIApplicFeeBorr" . "\t" .
            "FeesProcessFeeBorr" . "\t" .
            "FeesLine801UnderwritingFees" . "\t" .
            "LOCompensationLenderCompensationCreditAmountLine1" . "\t" .
            "LOCompensationLenderCompensationCreditAmountLine2" . "\t" .
            "FeesLine801UserDefFee1Descr" . "\t" .
            "FeesLine801UserDefFee1Borr" . "\t" .
            "FeesLine801UserDefinedFee2Descr" . "\t" .
            "FeesLine801UserDefinedFee2BorrAmt" . "\t" .
            "FeesLine801UserDefinedFee3Descr" . "\t" .
            "Line801UserDefinedFee3BorrAmt" . "\t" .
            "LOCompensationBorrowerPaidDiscountPointAmountLine1" . "\t" .
            "FeesAdjOrigChrgsAppliedtoGFE" . "\t" .
            "AppraisedValue" . "\t" .
            "SubjectPropertyPurchasePrice" . "\t" .
            "LoanAmount" . "\t" .
            "TotalLoanAmount" . "\t" .
            "HELOCAnnualFee" . "\t" .
            "HELOCDrawPeriodMos" . "\t" .
            "HELOCInitialAdvance" . "\t" .
            "HELOCRepayPeriodMos" . "\t" .
            "FeesCreditReportFeeAppliedtoGFE" . "\t" .
            "FeeDetailsLine804BorrowerPOCAmount" . "\t" .
            "FeeDetailsLine804BorrowerPTCAmount" . "\t" .
            "TPOCompanyName" . "\t" .
            "TPOCompanyAEName" . "\t" .
            "LoanTeamMemberNameAccountManager" . "\t" .
            "LoanTeamMemberEmailAccountManager" . "\t" .
            "FeesTaxSvcFeeBorr" . "\t" .
            "FeesFloodCertFeeBorr" . "\t" .
            "FeesLine808Descr" . "\t" .
            "FeesLine809Descr" . "\t" .
            "FeesDetails805BorrPTC" . "\t" .
            "FeesDetails805BorrPOC" . "\t" .
            "FeesDetails808BorrPTC" . "\t" .
            "FeesDetails808BorrPOC" . "\t" .
            "FeesDetails809BorrPTC" . "\t" .
            "FeesDetails809BorrPOC" . "\t" .
            "InvestorLockType" . "\t" .
            "TPOBranchAEName" . "\t" .
            "FeesLine810Descr" . "\t" .
            "FeesLine811Descr" . "\t" .
            "FeesDetails810BorrPTC" . "\t" .
            "FeesDetails810BorrPOC" . "\t" .
            "FeesDetails811BorrPTC" . "\t" .
            "FeesDetails811BorrPOC" . "\t" .
            "BorrowerPaidOrigination" . "\t" .
            "LenderPaidComp" . "\t" .
            "ApplicationFee" . "\t" .
            "ProcessingFee" . "\t" .
            "CreditReportFee" . "\t" .
            "AppraisalFee" . "\t" .
            "UnderwritingFee" . "\t" .
            "Custom1" . "\t" .
            "Custom2" . "\t" .
            "Custom3" . "\t" .
            "Custom4" . "\t" .
            "Custom5" . "\t" .
            "Custom6" . "\t" .
            "TierRebate" . "\t" .
            "BrokerBonus" . "\t" .
            "LicenseFee" . "\t" .
            "OtherFee" . "\t" .
            "LockDeskAdjust" . "\t" .
            "CustomFee" . "\t" .
            "LockFee1" . "\t" .
            "LockFee2" . "\t" .
            "LockFee3" . "\t" .
            "LockFee4" . "\t" .
            "BrokerCheckTotal" . "\t" .
            "PTCCredit" . "\t" .
            "PTCAppraisal" . "\t" .
            "CustomFeeDesc" . "\t" .
            "LockAdjust1" . "\t" .
            "LockAdjust2" . "\t" .
            "LockAdjust3" . "\t" .
            "LockAdjust4" . "\t" .
            "TPOBranchName" . "\t" .
            "LockFee5" . "\t" .
            "LockFee6" . "\t" .
            "LockFee7" . "\t" .
            "LockAdjust5" . "\t" .
            "LockAdjust6" . "\t" .
            "LockAdjust7" . "\t" .
            "Note" . "\t" .
            "TPOLoanOfficer" . "\n";

        $subservicing_data =
            "LoanNumber" . "\t" .
            "HiType" . "\t" .
            "ProductCode" . "\t" .
            "EscrowMonthlyPayment" . "\t" .
            "HomeownersIns" . "\t" .
            "FloodIns" . "\t" .
            "CountyMonthlyPayment" . "\t" .
            "CityMonthlyPayment" . "\t" .
            "LienMonthlyPayment" . "\t" .
            "PmiMonthlyPayment" . "\t" .
            "TotalMonthlyLoanPayment" . "\t" .
            "OriginalMortgageAmount" . "\t" .
            "CurrentPrincipalBalance" . "\t" .
            "ClosingDate" . "\t" .
            "FirstDueDate" . "\t" .
            "CurrentDueDate" . "\t" .
            "LoanMaturityDate" . "\t" .
            "BorrowerFirstName" . "\t" .
            "BorrowerLastName" . "\t" .
            "BorrowerMiddleInitial" . "\t" .
            "BorrowerSSN" . "\t" .
            "BorrowerCreditScore" . "\t" .
            "CoBorrowerFirstName" . "\t" .
            "CoBorrowerLastName" . "\t" .
            "CoBorrowerMiddleInitial" . "\t" .
            "CoBorrowerSSN" . "\t" .
            "CoBorrowerCreditScore" . "\t" .
            "BorrowerWorkNumber" . "\t" .
            "BorrowerCellPhoneNumber" . "\t" .
            "CoBorrowerHomePhone" . "\t" .
            "CoBorrowerWorkNumber" . "\t" .
            "CoBorrowerCellPhoneNumber" . "\t" .
            "PrepymtPenaltyInd" . "\t" .
            "InterestOnlyFlag" . "\t" .
            "InterestOnlyMonth" . "\t" .
            "OriginalAppraisedValue" . "\t" .
            "OriginalAppraisalDate" . "\t" .
            "NoteDate" . "\t" .
            "MersMinNumber" . "\t" .
            "MersRegistrationDate" . "\t" .
            "InterestCollectedAtClosing" . "\t" .
            "PointsPaidByBorrower" . "\t" .
            "EscrowBalance" . "\t" .
            "LateChargeCode" . "\t" .
            "LateChargePercentage" . "\t" .
            "LateChargeMaxDollarAmount" . "\t" .
            "EscrowCushion" . "\t" .
            "CountyCode" . "\t" .
            "GraceDays" . "\t" .
            "OccupancyCode" . "\t" .
            "PurchasePrice" . "\t" .
            "CensusTract" . "\t" .
            "PropertyType" . "\t" .
            "NumberOfUnits" . "\t" .
            "LoanPurpose" . "\t" .
            "LTV" . "\t" .
            "DTI" . "\t" .
            "FloodRequiredFlag" . "\t" .
            "FloodDeterminationDate" . "\t" .
            "CommunityPanelNumber" . "\t" .
            "FloodZone" . "\t" .
            "FloodMapDate" . "\t" .
            "FloodCertNumber" . "\t" .
            "FloodCmpco" . "\t" .
            "PmiMipPayee" . "\t" .
            "LoanOfficerName" . "\t" .
            "BorrowerDateOfBirth" . "\t" .
            "CoBorrowerDateOfBirth" . "\t" .
            "PropertyCountyName" . "\t" .
            "FloodPanelNumber" . "\t" .
            "PmiMipPercentOfCoverage" . "\t" .
            "PmiRatePercentage" . "\t" .
            "PmiMipBillCode" . "\t" .
            "Borrower3FirstName" . "\t" .
            "Borrower3LastName" . "\t" .
            "Borrower3MiddleName" . "\t" .
            "Borr3SSN" . "\t" .
            "Borrower4FirstName" . "\t" .
            "Borrower4LastName" . "\t" .
            "Borrower4MiddleName" . "\t" .
            "Borr4SSN" . "\t" .
            "Borrower5FirstName" . "\t" .
            "Borrower5LastName" . "\t" .
            "Borrower5MiddleName" . "\t" .
            "Borr5SSN" . "\t" .
            "Borr3HomePhone" . "\t" .
            "Borr4HomePhone" . "\t" .
            "Borr5HomePhone" . "\t" .
            "LotNumber" . "\t" .
            "PMI78PctTerminationDate" . "\t" .
            "PMIMidpointDate" . "\t" .
            "PMI" . "\t" .
            "MaturityDayPlus"  . "\t" .
            "PmiMipCertNo" . "\t" .
            "EscrowTaxes" . "\t" .
            "EscrowFlood" . "\t" .
            "EscrowHazard" . "\t" .
            "EscrowCityTaxes" . "\t" .
            "FHACase" . "\t" .
            "FeesInterestBorr" . "\t" .
            "FeesLoanOrigination" . "\t" .
            "PMIFinanced" . "\t" .
            "LoanProcessor" . "\t" .
            "AccountManager" . "\t" .
            "HousingAct" . "\t" .
            "HUDPremium" . "\t" .
            "FeesLoanDiscountFeeBorr" . "\t" .
            "HUDSponsorName" . "\t" .
            "HUDSponsorNMLS" . "\t" .
            "HUDSponsorTAXID" . "\t" .
            "FHALenderID" . "\t" .
            "DisclosureNameforFEMA" . "\t" .
            "FirstDueDateInvestor" . "\t" .
            "FileStarter" . "\t" .
            "TaxDue1" . "\t" .
            "HazDue1" . "\t" .
            "TaxDue2" . "\t" .
            "HazDue2" . "\t" .
            "PADate" . "\t" .
            "FundsSentDate" . "\t" .
            "FloodDue1" . "\t" .
            "FloodDue2" . "\t" .
            "PropertyParcel" . "\t" .
            "NextPaymentDate" . "\t" .
            "AgentName" . "\t" .
            "AgentPhone" . "\t" .
            "AgentEmail" . "\t" .
            "PaymentShipToName" . "\t" .
            "PaymentShipToAddress" . "\t" .
            "PaymentShipToCity" . "\t" .
            "PaymentShipToState" . "\t" .
            "PaymentShipToZip" . "\t" .
            "PaymentShipToPhone" . "\t" .
            "PMIPaidBy" . "\t" .
            "HELOCInitialAdvance" . "\t" .
            "HELOCMinimumPayment" . "\t" .
            "PurchaseAdvicePrincipal" . "\n";



        Storage::disk('local')->put('encompass_report.txt', $encompass_report);
        Storage::disk('local')->put('encompass_buyside.txt', $encompass_buyside);
        Storage::disk('local')->put('subservicing_data.txt', $subservicing_data);


        for ($i = 0; $i <= $max_loop; $i++) {

            $start_index = ($i * 250);
            $url_temp = 'https://api.elliemae.com/encompass/v1/loanPipeline?cursor=' . $loan_cursor . '&start=' . $start_index . '&limit=250';

            $response = Http::acceptJson()->withToken($access_token)->post(
                "$url_temp",
                [
                    "fields" => [
                        "Fields.2",
                        "Fields.3",
                        "Fields.4",
                        "Fields.11",
                        "Fields.12",
                        "Fields.13",
                        "Fields.14",
                        "Fields.15",
                        "Fields.16",
                        "Fields.19",
                        "Fields.60",
                        "Fields.65",
                        "Fields.66",
                        "Fields.67",
                        "Fields.68",
                        "Fields.69",
                        "Fields.78",
                        "Fields.97",
                        "Fields.98",
                        "Fields.109",
                        "Fields.136",
                        "Fields.154",
                        "Fields.155",
                        "Fields.230",
                        "Fields.231",
                        "Fields.232",
                        "Fields.235",
                        "Fields.247",
                        "Fields.315",
                        "Fields.334",
                        "Fields.336",
                        "Fields.352",
                        "Fields.353",
                        "Fields.356",
                        "Fields.362",
                        "Fields.364",
                        "Fields.367",
                        "Fields.409",
                        "Fields.420",
                        "Fields.430",
                        "Fields.432",
                        "Fields.454",
                        "Fields.541",
                        "Fields.608",
                        "Fields.672",
                        "Fields.674",
                        "Fields.682",
                        "Fields.688",
                        "Fields.689",
                        "Fields.695",
                        "Fields.696",
                        "Fields.697",
                        "Fields.700",
                        "Fields.740",
                        "Fields.742",
                        "Fields.745",
                        "Fields.749",
                        "Fields.761",
                        "Fields.762",
                        "Fields.799",
                        "Fields.976",
                        "Fields.984",
                        "Fields.1039",
                        "Fields.1040",
                        "Fields.1041",
                        "Fields.1045",
                        "Fields.1051",
                        "Fields.1059",
                        "Fields.1093",
                        "Fields.1109",
                        "Fields.1172",
                        "Fields.1177",
                        "Fields.1191",
                        "Fields.1240",
                        "Fields.1393",
                        "Fields.1396",
                        "Fields.1401",
                        "Fields.1402",
                        "Fields.1403",
                        "Fields.1416",
                        "Fields.1417",
                        "Fields.1418",
                        "Fields.1419",
                        "Fields.1480",
                        "Fields.1483",
                        "Fields.1490",
                        "Fields.1544",
                        "Fields.1612",
                        "Fields.1621",
                        "Fields.1625",
                        "Fields.1627",
                        "Fields.1699",
                        "Fields.1719",
                        "Fields.1730",
                        "Fields.1811",
                        "Fields.1819",
                        "Fields.1838",
                        "Fields.1839",
                        "Fields.1888",
                        "Fields.1889",
                        "Fields.1890",
                        "Fields.1891",
                        "Fields.1894",
                        "Fields.1990",
                        "Fields.1991",
                        "Fields.1993",
                        "Fields.1994",
                        "Fields.1996",
                        "Fields.1997",
                        "Fields.2014",
                        "Fields.2019",
                        "Fields.2023",
                        "Fields.2028",
                        "Fields.2152",
                        "Fields.2153",
                        "Fields.2154",
                        "Fields.2155",
                        "Fields.2156",
                        "Fields.2157",
                        "Fields.2158",
                        "Fields.2159",
                        "Fields.2160",
                        "Fields.2161",
                        "Fields.2162",
                        "Fields.2163",
                        "Fields.2164",
                        "Fields.2165",
                        "Fields.2166",
                        "Fields.2167",
                        "Fields.2168",
                        "Fields.2169",
                        "Fields.2170",
                        "Fields.2171",
                        "Fields.2202",
                        "Fields.2203",
                        "Fields.2206",
                        "Fields.2211",
                        "Fields.2218",
                        "Fields.2231",
                        "Fields.2232",
                        "Fields.2233",
                        "Fields.2234",
                        "Fields.2235",
                        "Fields.2236",
                        "Fields.2237",
                        "Fields.2238",
                        "Fields.2239",
                        "Fields.2240",
                        "Fields.2241",
                        "Fields.2242",
                        "Fields.2243",
                        "Fields.2244",
                        "Fields.2245",
                        "Fields.2246",
                        "Fields.2247",
                        "Fields.2248",
                        "Fields.2249",
                        "Fields.2250",
                        "Fields.2251",
                        "Fields.2252",
                        "Fields.2273",
                        "Fields.2274",
                        "Fields.2276",
                        "Fields.2277",
                        "Fields.2287",
                        "Fields.2293",
                        "Fields.2294",
                        "Fields.2295",
                        "Fields.2296",
                        "Fields.2297",
                        "Fields.2353",
                        "Fields.2363",
                        "Fields.2364",
                        "Fields.2365",
                        "Fields.2370",
                        "Fields.2397",
                        "Fields.2625",
                        "Fields.2634",
                        "Fields.2832",
                        "Fields.2973",
                        "Fields.2977",
                        "Fields.3143",
                        "Fields.3152",
                        "Fields.3197",
                        "Fields.3238",
                        "Fields.3261",
                        "Fields.3332",
                        "Fields.3336",
                        "Fields.3380",
                        "Fields.3382",
                        "Fields.3384",
                        "Fields.3386",
                        "Fields.3388",
                        "Fields.3390",
                        "Fields.3392",
                        "Fields.3514",
                        "Fields.3533",
                        "Fields.3548",
                        "Fields.4000",
                        "Fields.4001",
                        "Fields.4002",
                        "Fields.4004",
                        "Fields.4005",
                        "Fields.4006",
                        "Fields.4085",
                        "Fields.356136",
                        "Fields.4000#2",
                        "Fields.4000#3",
                        "Fields.4000#4",
                        "Fields.4001#2",
                        "Fields.4001#3",
                        "Fields.4001#4",
                        "Fields.4002#2",
                        "Fields.4002#3",
                        "Fields.4002#4",
                        "Fields.65#2",
                        "Fields.65#3",
                        "Fields.65#4",
                        "Fields.66#2",
                        "Fields.66#3",
                        "Fields.66#4",
                        "Fields.CD1.X12",
                        "Fields.CD1.X14",
                        "Fields.CD2.XSTG",
                        "CurrentLoanAssociate.FullName",
                        "Fields.CUST16FV",
                        "Fields.CUST43FV",
                        "Fields.CUST45FV",
                        "Fields.CUST46FV",
                        "Fields.CX.ACCD1",
                        "Fields.CX.ACCD10",
                        "Fields.CX.ACCD11",
                        "Fields.CX.ACCD12",
                        "Fields.CX.ACCD13",
                        "Fields.CX.ACCD14",
                        "Fields.CX.ACCD15",
                        "Fields.CX.ACCD16",
                        "Fields.CX.ACCD17",
                        "Fields.CX.ACCD18",
                        "Fields.CX.ACCD19",
                        "Fields.CX.ACCD2",
                        "Fields.CX.ACCD20",
                        "Fields.CX.ACCD21",
                        "Fields.CX.ACCD22",
                        "Fields.CX.ACCD23",
                        "Fields.CX.ACCD25",
                        "Fields.CX.ACCD26",
                        "Fields.CX.ACCD27",
                        "Fields.CX.ACCD3",
                        "Fields.CX.ACCD4",
                        "Fields.CX.ACCD5",
                        "Fields.CX.ACCD6",
                        "Fields.CX.ACCD7",
                        "Fields.CX.ACCD8",
                        "Fields.CX.ACCD9",
                        "Fields.CX.ACCFEECUSTOMN",
                        "Fields.CX.ACCTOTAL",
                        "Fields.CX.CONDITIONCLEAREDBY",
                        "Fields.CX.CONDITIONCLEAREDDATE",
                        "Fields.CX.DOCUMENTSHIPPINGREADYBY1",
                        "Fields.CX.DOCUMENTSHIPPINGREADYDATE",
                        "Fields.CX.HUD0141",
                        "Fields.CX.HUD0142",
                        "Fields.CX.HUD0144",
                        "Fields.CX.HUD0241",
                        "Fields.CX.HUD0242",
                        "Fields.CX.HUD0244",
                        "Fields.CX.SHIPCLEARFORDOCSDAYS",
                        "Fields.CX.SHIPCLOSINGDAYS",
                        "Fields.CX.SHIPCLOSINGPACKAGE",
                        "Fields.CX.SHIPCOORDINATOR",
                        "Fields.CX.SHIPDECISIONDAYS",
                        "Fields.CX.SHIPDOCPREPDAYS",
                        "Fields.CX.SHIPDOCRETURNDAYS",
                        "Fields.CX.SHIPFINALAPPROVALDAYS",
                        "Fields.CX.SHIPPREAPPROVEDAYS",
                        "Fields.CX.SHIPPTDDAYS",
                        "Fields.CX.SHIPPURCHASEDAYS",
                        "Fields.CX.SHIPSETUPDAYS",
                        "Fields.CX.SHIPSHIPDAYS",
                        "Fields.CX.SHIPSUSPCOORDINATOR",
                        "Fields.CX.SHIPSUSPENSECLEARDAYS",
                        "Fields.CX.WC.PMI.PAID.BY",
                        "Fields.Document.Company.Flood Certificate",
                        "Fields.Document.Company.Mortgate Insurance",
                        "Fields.EDISCLOSEDTRK.FulfilledBy.1",
                        "Fields.EDISCLOSEDTRK.SentDate.1",
                        "Fields.FE0117",
                        "Fields.FE0217",
                        "Fields.FR0104",
                        "Fields.FR0106",
                        "Fields.FR0107",
                        "Fields.FR0108",
                        "Fields.HUD24",
                        "Fields.ISPAY.Escrow.0.AMT",
                        "Fields.ISPAY.Escrow.0.DATE",
                        "Fields.ISPAY.Escrow.0.ESCROWTYPE",
                        "Fields.ISPAY.Escrow.0.INTNAME",
                        "Fields.ISPAY.Escrow.1.AMT",
                        "Fields.ISPAY.Escrow.1.DATE",
                        "Fields.ISPAY.Escrow.1.ESCROWTYPE",
                        "Fields.ISPAY.Escrow.1.INTNAME",
                        "Fields.ISPAY.Escrow.2.AMT",
                        "Fields.ISPAY.Escrow.2.DATE",
                        "Fields.ISPAY.Escrow.2.ESCROWTYPE",
                        "Fields.ISPAY.Escrow.2.INTNAME",
                        "Fields.ISPAY.Escrow.3.AMT",
                        "Fields.ISPAY.Escrow.3.DATE",
                        "Fields.ISPAY.Escrow.3.ESCROWTYPE",
                        "Fields.ISPAY.Escrow.3.INTNAME",
                        "Fields.ISPAY.Escrow.4.AMT",
                        "Fields.ISPAY.Escrow.4.DATE",
                        "Fields.ISPAY.Escrow.4.ESCROWTYPE",
                        "Fields.ISPAY.Escrow.4.INTNAME",
                        "Fields.L228",
                        "Fields.L268",
                        "Fields.L770",
                        "Fields.LoanTeamMember.Email.Account Manager",
                        "Fields.LoanTeamMember.Email.File Starter",
                        "Fields.LoanTeamMember.Email.Loan Officer",
                        "Fields.LoanTeamMember.Name.Account Manager",
                        "Fields.LoanTeamMember.Name.Doc Drawer",
                        "Fields.LoanTeamMember.Name.File Starter",
                        "Fields.LoanTeamMember.Name.Jr. Underwriter",
                        "Fields.LoanTeamMember.Name.Loan Officer",
                        "Fields.Log.MS.Date.Clear for Docs",
                        "Fields.Log.MS.Date.Decision",
                        "Fields.Log.MS.Date.Doc Preparation",
                        "Fields.Log.MS.Date.Final Approval",
                        "Fields.Log.MS.Date.Funding",
                        "Fields.Log.MS.Date.Pre-approval",
                        "Fields.Log.MS.Date.Processing",
                        "Fields.Log.MS.Date.PTD Processing",
                        "Fields.Log.MS.Date.Set Up",
                        "Fields.Log.MS.Date.Docs Returned",
                        "Fields.Log.MS.LastCompleted",
                        "Fields.MORNET.X67",
                        "Fields.MS.STATUSDATE",
                        "Fields.NEWHUD.X1142",
                        "Fields.NEWHUD.X1144",
                        "Fields.NEWHUD.X1151",
                        "Fields.NEWHUD.X126",
                        "Fields.NEWHUD.X127",
                        "Fields.NEWHUD.X128",
                        "Fields.NEWHUD.X129",
                        "Fields.NEWHUD.X16",
                        "Fields.NEWHUD.X1719",
                        "Fields.NEWHUD.X1719749",
                        "Fields.NEWHUD.X1726",
                        "Fields.NEWHUD.X225",
                        "Fields.NEWHUD.X337",
                        "Fields.NEWHUD.X338",
                        "Fields.NEWHUD.X339",
                        "Fields.NEWHUD.X400",
                        "Fields.NEWHUD.X610",
                        "Fields.NEWHUD2.X1099",
                        "Fields.NEWHUD2.X1101",
                        "Fields.NEWHUD2.X1132",
                        "Fields.NEWHUD2.X1134",
                        "Fields.NEWHUD2.X1231",
                        "Fields.NEWHUD2.X1233",
                        "Fields.NEWHUD2.X1264",
                        "Fields.NEWHUD2.X1266",
                        "Fields.NEWHUD2.X1297",
                        "Fields.NEWHUD2.X1299",
                        "Fields.NEWHUD2.X1330",
                        "Fields.NEWHUD2.X1332",
                        "Fields.NOTICES.X50",
                        "Fields.NOTICES.X96",
                        "Fields.ORGID",
                        "Fields.RE88395.X322",
                        "Fields.SERVICE.X74",
                        "Fields.Terms.IntrOnly",
                        "Fields.TPO.X14",
                        "Fields.TPO.X18",
                        "Fields.TPO.X19",
                        "Fields.TPO.X20",
                        "Fields.TPO.X22",
                        "Fields.TPO.X30",
                        "Fields.TPO.X38",
                        "Fields.TPO.X54",
                        "Fields.TPO.X61",
                        "Fields.TPO.X63",
                        "Fields.ULDD.FNM.X50",
                        "Fields.VASUMM.X23",
                        "Fields.VEND.X167",
                        "Fields.VEND.X200",
                        "Fields.VEND.X263",
                        "Fields.VEND.X529",
                        "Fields.VEND.X530",
                        "Fields.VEND.X532",
                        "Fields.VEND.X533",
                        "Fields.VEND.X534",
                        "Fields.VEND.X536"
                    ],
                ]
            );

            $decoded = json_decode($response->body(), true);
            $sample = collect($decoded);
            $encompass_report = null;
            $encompass_buyside = null;
            $subservicing_data = null;

            foreach ($sample as $item) {
                $encompass_report .=
                    (isset($item['fields']['Fields.745']) ? date('m/d/Y', strtotime($item['fields']['Fields.745'])) : "") . "\t" .
                    (isset($item['fields']['Fields.2370']) ? date('m/d/Y', strtotime($item['fields']['Fields.2370'])) : "") . "\t" .
                    ($item['fields']['Fields.364'] ?? "") . "\t" .
                    ($item['fields']['Fields.4000'] ?? "") . "\t" .
                    ($item['fields']['Fields.4002'] ?? "") . "\t" .
                    ($item['fields']['Fields.352'] ?? "") . "\t" .
                    ($item['fields']['Fields.11'] ?? "") . "\t" .
                    ($item['fields']['Fields.12'] ?? "") . "\t" .
                    ($item['fields']['Fields.14'] ?? "") . "\t" .
                    ($item['fields']['Fields.15'] ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X263'] ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X200'] ?? "") . "\t" .
                    ($item['fields']['Fields.2161']  ?? "") . "\t" .
                    ($item['fields']['Fields.2202']  ?? "") . "\t" .
                    ($item['fields']['Fields.2203']  ?? "") . "\t" .
                    ($item['fields']['Fields.2231']  ?? "") . "\t" .
                    ($item['fields']['Fields.2232']  ?? "") . "\t" .
                    ($item['fields']['Fields.2273']  ?? "") . "\t" .
                    ($item['fields']['Fields.2274']  ?? "") . "\t" .
                    ($item['fields']['Fields.2276']  ?? "") . "\t" .
                    ($item['fields']['Fields.2277']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.2297']) ? date('m/d/Y', strtotime($item['fields']['Fields.2297'])) : "") . "\t" .
                    (isset($item['fields']['Fields.2206']) ? date('m/d/Y', strtotime($item['fields']['Fields.2206'])) : "") . "\t" .
                    ($item['fields']['Fields.2295']  ?? "") . "\t" .
                    ($item['fields']['Fields.2296']  ?? "") . "\t" .
                    ($item['fields']['Fields.2028']  ?? "") . "\t" .
                    ($item['fields']['Fields.2']  ?? "") . "\t" .
                    ($item['fields']['Fields.1990']  ?? "") . "\t" .
                    ($item['fields']['Fields.1393']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.1997']) ? date('m/d/Y', strtotime($item['fields']['Fields.1997'])) : "") . "\t" .
                    (isset($item['fields']['Fields.2014']) ? date('m/d/Y', strtotime($item['fields']['Fields.2014'])) : "") . "\t" .
                    ($item['fields']['Fields.1811']  ?? "") . "\t" .
                    ($item['fields']['Fields.FR0104'] ?? "") . "\t" .
                    ($item['fields']['Fields.FR0106'] ?? "") . "\t" .
                    ($item['fields']['Fields.FR0107'] ?? "") . "\t" .
                    ($item['fields']['Fields.FR0108'] ?? "") . "\t" .
                    ($item['fields']['Fields.Log.MS.LastCompleted'] ?? "") . "\t" .
                    ($item['fields']['Fields.1240']  ?? "") . "\t" .
                    ($item['fields']['Fields.1172']  ?? "") . "\t" .
                    ($item['fields']['Fields.2218']  ?? "") . "\t" .
                    ($item['fields']['Fields.2233']  ?? "") . "\t" .
                    ($item['fields']['Fields.2234']  ?? "") . "\t" .
                    ($item['fields']['Fields.2235']  ?? "") . "\t" .
                    ($item['fields']['Fields.2236']  ?? "") . "\t" .
                    ($item['fields']['Fields.2237']  ?? "") . "\t" .
                    ($item['fields']['Fields.2238']  ?? "") . "\t" .
                    ($item['fields']['Fields.2239']  ?? "") . "\t" .
                    ($item['fields']['Fields.2240']  ?? "") . "\t" .
                    ($item['fields']['Fields.2241']  ?? "") . "\t" .
                    ($item['fields']['Fields.2242']  ?? "") . "\t" .
                    ($item['fields']['Fields.2243']  ?? "") . "\t" .
                    ($item['fields']['Fields.2244']  ?? "") . "\t" .
                    ($item['fields']['Fields.2245']  ?? "") . "\t" .
                    ($item['fields']['Fields.2246']  ?? "") . "\t" .
                    ($item['fields']['Fields.315']  ?? "") . "\t" .
                    ($item['fields']['Fields.4085']  ?? "") . "\t" .
                    ($item['fields']['Fields.232']  ?? "") . "\t" .
                    ($item['fields']['Fields.HUD24'] ?? "") . "\t" .
                    ($item['fields']['Fields.66']  ?? "") . "\t" .
                    ($item['fields']['Fields.984']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.682']) ? date('m/d/Y', strtotime($item['fields']['Fields.682'])) : "") . "\t" .
                    ($item['fields']['Fields.2019']  ?? "") . "\t" .
                    ($item['fields']['CurrentLoanAssociate.FullName'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Set Up']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Set Up'])) : "") . "\t" .
                    ($item['fields']['Fields.420']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Doc Preparation']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Doc Preparation'])) : "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.Doc Drawer'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.1994']) ? date('m/d/Y', strtotime($item['fields']['Fields.1994'])) : "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Clear for Docs']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Clear for Docs'])) : "") . "\t" .
                    ($item['fields']['Fields.16']  ?? "") . "\t" .
                    ($item['fields']['Fields.1040']  ?? "") . "\t" .
                    ($item['fields']['Fields.136']  ?? "") . "\t" .
                    ($item['fields']['Fields.13']  ?? "") . "\t" .
                    ($item['fields']['Fields.19']  ?? "") . "\t" .
                    ($item['fields']['Fields.MS.STATUSDATE'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.MS.STATUSDATE']) ? date('m/d/Y', strtotime($item['fields']['Fields.MS.STATUSDATE'])) : "") . "\t" .
                    ($item['fields']['Fields.356']  ?? "") . "\t" .
                    ($item['fields']['Fields.1416']  ?? "") . "\t" .
                    ($item['fields']['Fields.1417']  ?? "") . "\t" .
                    ($item['fields']['Fields.1418']  ?? "") . "\t" .
                    ($item['fields']['Fields.1419']  ?? "") . "\t" .
                    ($item['fields']['Fields.1819']  ?? "") . "\t" .
                    ($item['fields']['Fields.1041']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Docs Returned']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Docs Returned'])) : "") . "\t" .
                    ($item['fields']['Fields.TPO.X30'] ?? "") . "\t" .
                    ($item['fields']['Fields.1396']  ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X14'] ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X18'] ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X19'] ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X20'] ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X22'] ?? "") . "\t" .
                    ($item['fields']['Fields.1401']  ?? "") . "\t" .
                    ($item['fields']['Fields.3261']  ?? "") . "\t" .
                    ($item['fields']['Fields.65']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.762']) ? date('m/d/Y', strtotime($item['fields']['Fields.762'])) : "") . "\t" .
                    ($item['fields']['Fields.TPO.X63'] ?? "") . "\t" .
                    ($item['fields']['Fields.3332']  ?? "") . "\t" .
                    ($item['fields']['Fields.3']  ?? "") . "\t" .
                    ($item['fields']['Fields.4']  ?? "") . "\t" .
                    ($item['fields']['Fields.1993']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Decision']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Decision'])) : "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Final Approval']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Final Approval'])) : "") . "\t" .
                    ($item['fields']['Fields.ORGID'] ?? "") . "\t" .
                    ($item['fields']['Fields.CUST16FV'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.3143']) ? date('m/d/Y', strtotime($item['fields']['Fields.3143'])) : "") . "\t" .
                    (isset($item['fields']['Fields.3152']) ? date('m/d/Y', strtotime($item['fields']['Fields.3152'])) : "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Email.File Starter'] ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Email.Loan Officer'] ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.File Starter'] ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.Loan Officer'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Processing']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Processing'])) : "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Pre-approval']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Pre-approval'])) : "") . "\t" .
                    ($item['fields']['Fields.MORNET.X67'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPSETUPDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPPREAPPROVEDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPDECISIONDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPPTDDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPCLEARFORDOCSDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPDOCPREPDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPDOCRETURNDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPFINALAPPROVALDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPCLOSINGDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPSHIPDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPSUSPENSECLEARDAYS'] ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPPURCHASEDAYS'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.PTD Processing']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.PTD Processing'])) : "") . "\t" .
                    ($item['fields']['Fields.2247'] ?? "") . "\t" .
                    ($item['fields']['Fields.2248'] ?? "") . "\t" .
                    ($item['fields']['Fields.2249'] ?? "") . "\t" .
                    ($item['fields']['Fields.2250'] ?? "") . "\t" .
                    ($item['fields']['Fields.2251'] ?? "") . "\t" .
                    ($item['fields']['Fields.2252'] ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.Account Manager'] ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.Jr. Underwriter'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.0.DATE']) ? date('m/d/Y', strtotime($item['fields']['Fields.ISPAY.Escrow.0.DATE'])) : "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.0.ESCROWTYPE'] ?? "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.0.INTNAME'] ?? "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.0.AMT']) ? (str_replace(',', '', $item['fields']['Fields.ISPAY.Escrow.0.AMT'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD.X1719']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD.X1719'])) : "") . "\t" .
                    ($item['fields']['Fields.TPO.X54']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.749']) ? date('m/d/Y', strtotime($item['fields']['Fields.749'])) : "") . "\t" .
                    (isset($item['fields']['Fields.Log.MS.Date.Funding']) ? date('m/d/Y', strtotime($item['fields']['Fields.Log.MS.Date.Funding'])) : "") . "\t" .
                    ($item['fields']['Fields.799']  ?? "") . "\t" .
                    ($item['fields']['Fields.3238']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.3197']) ? date('m/d/Y', strtotime($item['fields']['Fields.3197'])) : "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.1.DATE']) ? date('m/d/Y', strtotime($item['fields']['Fields.ISPAY.Escrow.1.DATE'])) : "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.1.ESCROWTYPE']  ?? "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.1.INTNAME']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.1.AMT']) ? (str_replace(',', '', $item['fields']['Fields.ISPAY.Escrow.1.AMT'])) : "") . "\t" .
                    ($item['fields']['Fields.1991']  ?? "") . "\t" .
                    ($item['fields']['Fields.EDISCLOSEDTRK.FulfilledBy.1']  ?? "") . "\t" .
                    ($item['fields']['Fields.EDISCLOSEDTRK.SentDate.1']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.2.DATE']) ? date('m/d/Y', strtotime($item['fields']['Fields.ISPAY.Escrow.2.DATE'])) : "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.2.ESCROWTYPE']  ?? "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.2.INTNAME']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.2.AMT']) ? (str_replace(',', '', $item['fields']['Fields.ISPAY.Escrow.2.AMT'])) : "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.3.DATE']) ? date('m/d/Y', strtotime($item['fields']['Fields.ISPAY.Escrow.3.DATE'])) : "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.3.ESCROWTYPE']  ?? "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.3.INTNAME']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.3.AMT']) ? (str_replace(',', '', $item['fields']['Fields.ISPAY.Escrow.3.AMT'])) : "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.4.DATE']) ? date('m/d/Y', strtotime($item['fields']['Fields.ISPAY.Escrow.4.DATE'])) : "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.4.ESCROWTYPE']  ?? "") . "\t" .
                    ($item['fields']['Fields.ISPAY.Escrow.4.INTNAME']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.ISPAY.Escrow.4.AMT']) ? (str_replace(',', '', $item['fields']['Fields.ISPAY.Escrow.4.AMT'])) : "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPCOORDINATOR']  ?? "") . "\t" .
                    ($item['fields']['Fields.CX.SHIPSUSPCOORDINATOR']  ?? "") . "\t" .
                    ($item['fields']['Fields.CX.DOCUMENTSHIPPINGREADYBY1']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.CX.DOCUMENTSHIPPINGREADYDATE']) ? (str_replace(',', '', $item['fields']['Fields.CX.DOCUMENTSHIPPINGREADYDATE'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.SHIPCLOSINGPACKAGE']) ? (str_replace(',', '', $item['fields']['Fields.CX.SHIPCLOSINGPACKAGE'])) : "") . "\t" .
                    ($item['fields']['Fields.CX.CONDITIONCLEAREDBY']  ?? "") . "\t" .
                    (isset($item['fields']['Fields.CX.CONDITIONCLEAREDDATE']) ? (str_replace(',', '', $item['fields']['Fields.CX.CONDITIONCLEAREDDATE'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CD1.X12']) ? (str_replace(',', '', $item['fields']['Fields.CD1.X12'])) : "") . "\n";

                $encompass_buyside .=
                    ($item['fields']['Fields.364']   ?? "") . "\t" .
                    ($item['fields']['Fields.68']   ?? "") . "\t" .
                    ($item['fields']['Fields.69']   ?? "") . "\t" .
                    ($item['fields']['Fields.1041']   ?? "") . "\t" .
                    ($item['fields']['Fields.353']   ?? "") . "\t" .
                    ($item['fields']['Fields.976']   ?? "") . "\t" .
                    ($item['fields']['Fields.3']   ?? "") . "\t" .
                    ($item['fields']['Fields.420']   ?? "") . "\t" .
                    ($item['fields']['Fields.1172']   ?? "") . "\t" .
                    ($item['fields']['Fields.4']   ?? "") . "\t" .
                    ($item['fields']['Fields.19']   ?? "") . "\t" .
                    ($item['fields']['Fields.1811']   ?? "") . "\t" .
                    ($item['fields']['Fields.740']   ?? "") . "\t" .
                    ($item['fields']['Fields.742']   ?? "") . "\t" .
                    ($item['fields']['Fields.1401']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.761']) ? date('m/d/Y', strtotime($item['fields']['Fields.761'])) : "") . "\t" .
                    ($item['fields']['Fields.432']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.762']) ? date('m/d/Y', strtotime($item['fields']['Fields.762'])) : "") . "\t" .
                    ($item['fields']['Fields.VASUMM.X23']   ?? "") . "\t" .
                    ($item['fields']['Fields.2293']   ?? "") . "\t" .
                    ($item['fields']['Fields.2294']   ?? "") . "\t" .
                    ($item['fields']['Fields.1544']   ?? "") . "\t" .
                    ($item['fields']['Fields.2152']   ?? "") . "\t" .
                    ($item['fields']['Fields.2153']   ?? "") . "\t" .
                    ($item['fields']['Fields.2154']   ?? "") . "\t" .
                    ($item['fields']['Fields.2155']   ?? "") . "\t" .
                    ($item['fields']['Fields.2156']   ?? "") . "\t" .
                    ($item['fields']['Fields.2157']   ?? "") . "\t" .
                    ($item['fields']['Fields.2158']   ?? "") . "\t" .
                    ($item['fields']['Fields.2159']   ?? "") . "\t" .
                    ($item['fields']['Fields.2160']   ?? "") . "\t" .
                    ($item['fields']['Fields.2161']   ?? "") . "\t" .
                    ($item['fields']['Fields.2162']   ?? "") . "\t" .
                    ($item['fields']['Fields.2163']   ?? "") . "\t" .
                    ($item['fields']['Fields.2164']   ?? "") . "\t" .
                    ($item['fields']['Fields.2165']   ?? "") . "\t" .
                    ($item['fields']['Fields.2166']   ?? "") . "\t" .
                    ($item['fields']['Fields.2167']   ?? "") . "\t" .
                    ($item['fields']['Fields.2168']   ?? "") . "\t" .
                    ($item['fields']['Fields.2169']   ?? "") . "\t" .
                    ($item['fields']['Fields.2170']   ?? "") . "\t" .
                    ($item['fields']['Fields.2171']   ?? "") . "\t" .
                    ($item['fields']['Fields.2202']   ?? "") . "\t" .
                    ($item['fields']['Fields.2203']   ?? "") . "\t" .
                    ($item['fields']['Fields.697']   ?? "") . "\t" .
                    ($item['fields']['Fields.696']   ?? "") . "\t" .
                    ($item['fields']['Fields.695']   ?? "") . "\t" .
                    ($item['fields']['Fields.247']   ?? "") . "\t" .
                    ($item['fields']['Fields.688']   ?? "") . "\t" .
                    ($item['fields']['Fields.689']   ?? "") . "\t" .
                    ($item['fields']['Fields.2625']   ?? "") . "\t" .
                    ($item['fields']['Fields.1699']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.454']) ? (str_replace(',', '', $item['fields']['Fields.454'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD.X225']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD.X225'])) : "") . "\t" .
                    (isset($item['fields']['Fields.L228']) ? (str_replace(',', '', $item['fields']['Fields.L228'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1621']) ? (str_replace(',', '', $item['fields']['Fields.1621'])) : "") . "\t" .
                    (isset($item['fields']['Fields.367']) ? (str_replace(',', '', $item['fields']['Fields.367'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD.X1142']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD.X1142'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD.X1144']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD.X1144'])) : "") . "\t" .
                    ($item['fields']['Fields.154']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.155']) ? (str_replace(',', '', $item['fields']['Fields.155'])) : "") . "\t" .
                    ($item['fields']['Fields.1627']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.1625']) ? (str_replace(',', '', $item['fields']['Fields.1625'])) : "") . "\t" .
                    ($item['fields']['Fields.1838']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.1839']) ? (str_replace(',', '', $item['fields']['Fields.1839'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD.X1151']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD.X1151'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD.X16']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD.X16'])) : "") . "\t" .
                    (isset($item['fields']['Fields.356']) ? (str_replace(',', '', $item['fields']['Fields.356'])) : "") . "\t" .
                    (isset($item['fields']['Fields.136']) ? (str_replace(',', '', $item['fields']['Fields.136'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1109']) ? (str_replace(',', '', $item['fields']['Fields.1109'])) : "") . "\t" .
                    (isset($item['fields']['Fields.2']) ? (str_replace(',', '', $item['fields']['Fields.2'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1891']) ? (str_replace(',', '', $item['fields']['Fields.1891'])) : "") . "\t" .
                    ($item['fields']['Fields.1889']   ?? "") . "\t" .
                    ($item['fields']['Fields.1888']   ?? "") . "\t" .
                    ($item['fields']['Fields.1890']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X610']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1101']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1101'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1099']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1099'])) : "") . "\t" .
                    ($item['fields']['Fields.TPO.X14']   ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X30']   ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.Account Manager']   ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Email.Account Manager']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.336']) ? (str_replace(',', '', $item['fields']['Fields.336'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD.X400']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD.X400'])) : "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X126']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X127']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1132']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1132'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1134']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1134'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1231']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1231'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1233']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1233'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1264']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1264'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1266']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1266'])) : "") . "\t" .
                    ($item['fields']['Fields.2287']   ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X54']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X128']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X129']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1297']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1297'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1299']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1299'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1330']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1330'])) : "") . "\t" .
                    (isset($item['fields']['Fields.NEWHUD2.X1332']) ? (str_replace(',', '', $item['fields']['Fields.NEWHUD2.X1332'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD1']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD1'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD2']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD2'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD3']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD3'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD4']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD4'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD5']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD5'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD6']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD6'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD7']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD7'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD8']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD8'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD9']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD9'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD10']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD10'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD11']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD11'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD12']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD12'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD13']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD13'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD14']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD14'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD15']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD15'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD16']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD16'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD17']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD17'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD18']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD18'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD19']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD19'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD20']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD20'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD21']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD21'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD22']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD22'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD23']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD23'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCTOTAL']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCTOTAL'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CUST45FV']) ? (str_replace(',', '', $item['fields']['Fields.CUST45FV'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CUST43FV']) ? (str_replace(',', '', $item['fields']['Fields.CUST43FV'])) : "") . "\t" .
                    ($item['fields']['Fields.CX.ACCFEECUSTOMN']   ?? "") . "\t" .
                    ($item['fields']['Fields.3380']   ?? "") . "\t" .
                    ($item['fields']['Fields.3382']   ?? "") . "\t" .
                    ($item['fields']['Fields.3384']   ?? "") . "\t" .
                    ($item['fields']['Fields.3386']   ?? "") . "\t" .
                    ($item['fields']['Fields.TPO.X38']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD25']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD25'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD26']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD26'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.ACCD27']) ? (str_replace(',', '', $item['fields']['Fields.CX.ACCD27'])) : "") . "\t" .
                    ($item['fields']['Fields.3388']   ?? "") . "\t" .
                    ($item['fields']['Fields.3390']   ?? "") . "\t" .
                    ($item['fields']['Fields.3392']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.CUST46FV']) ? (str_replace("\n", '<BR>', (str_replace("\r", '<BR>', $item['fields']['Fields.CUST46FV'])))) : "") . "\t" .
                    ($item['fields']['Fields.TPO.X61']   ?? "") . "\n";

                $subservicing_data .=
                    ($item['fields']['Fields.364']   ?? "") . "\t" .
                    ($item['fields']['Fields.420']   ?? "") . "\t" .
                    ($item['fields']['Fields.608']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.HUD24']) ? (str_replace(',', '', $item['fields']['Fields.HUD24'])) : "") . "\t" .
                    (isset($item['fields']['Fields.230']) ? (str_replace(',', '', $item['fields']['Fields.230'])) : "") . "\t" .
                    (isset($item['fields']['Fields.235']) ? (str_replace(',', '', $item['fields']['Fields.235'])) : "") . "\t" .
                    (isset($item['fields']['Fields.231']) ? (str_replace(',', '', $item['fields']['Fields.231'])) : "") . "\t" .
                    (isset($item['fields']['Fields.L268']) ? (str_replace(',', '', $item['fields']['Fields.L268'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1730']) ? (str_replace(',', '', $item['fields']['Fields.1730'])) : "") . "\t" .
                    (isset($item['fields']['Fields.232']) ? (str_replace(',', '', $item['fields']['Fields.232'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CD1.X14']) ? (str_replace(',', '', $item['fields']['Fields.CD1.X14'])) : "") . "\t" .
                    (isset($item['fields']['Fields.2']) ? (str_replace(',', '', $item['fields']['Fields.2'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1109']) ? (str_replace(',', '', $item['fields']['Fields.1109'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1996']) ? date('m/d/Y', strtotime($item['fields']['Fields.1996'])) : "") . "\t" .
                    (isset($item['fields']['Fields.682']) ? date('m/d/Y', strtotime($item['fields']['Fields.682'])) : "") . "\t" .
                    (isset($item['fields']['Fields.3514']) ? date('m/d/Y', strtotime($item['fields']['Fields.3514'])) : "") . "\t" .
                    (isset($item['fields']['Fields.78']) ? date('m/d/Y', strtotime($item['fields']['Fields.78'])) : "") . "\t" .
                    ($item['fields']['Fields.4000']   ?? "") . "\t" .
                    ($item['fields']['Fields.4002']   ?? "") . "\t" .
                    ($item['fields']['Fields.4001']   ?? "") . "\t" .
                    ($item['fields']['Fields.65']   ?? "") . "\t" .
                    ($item['fields']['Fields.67']   ?? "") . "\t" .
                    ($item['fields']['Fields.4004']   ?? "") . "\t" .
                    ($item['fields']['Fields.4006']   ?? "") . "\t" .
                    ($item['fields']['Fields.4005']   ?? "") . "\t" .
                    ($item['fields']['Fields.97']   ?? "") . "\t" .
                    ($item['fields']['Fields.60']   ?? "") . "\t" .
                    ($item['fields']['Fields.FE0117']   ?? "") . "\t" .
                    ($item['fields']['Fields.1490']   ?? "") . "\t" .
                    ($item['fields']['Fields.98']   ?? "") . "\t" .
                    ($item['fields']['Fields.FE0217']   ?? "") . "\t" .
                    ($item['fields']['Fields.1480']   ?? "") . "\t" .
                    ($item['fields']['Fields.RE88395.X322']   ?? "") . "\t" .
                    ($item['fields']['Fields.Terms.IntrOnly']   ?? "") . "\t" .
                    ($item['fields']['Fields.1177']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.356']) ? (str_replace(',', '', $item['fields']['Fields.356'])) : "") . "\t" .
                    ($item['fields']['Fields.2353']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.L770']) ? date('m/d/Y', strtotime($item['fields']['Fields.L770'])) : "") . "\t" .
                    ($item['fields']['Fields.1051']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.2023']) ? date('m/d/Y', strtotime($item['fields']['Fields.2023'])) : "") . "\t" .
                    (isset($item['fields']['Fields.334']) ? (str_replace(',', '', $item['fields']['Fields.334'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1191']) ? (str_replace(',', '', $item['fields']['Fields.1191'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CD2.XSTG']) ? (str_replace(',', '', $item['fields']['Fields.CD2.XSTG'])) : "") . "\t" .
                    ($item['fields']['Fields.1719']   ?? "") . "\t" .
                    ($item['fields']['Fields.674']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.2832']) ? (str_replace(',', '', $item['fields']['Fields.2832'])) : "") . "\t" .
                    ($item['fields']['Fields.SERVICE.X74']   ?? "") . "\t" .
                    ($item['fields']['Fields.1396']   ?? "") . "\t" .
                    ($item['fields']['Fields.672']   ?? "") . "\t" .
                    ($item['fields']['Fields.1811']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.136']) ? (str_replace(',', '', $item['fields']['Fields.136'])) : "") . "\t" .
                    ($item['fields']['Fields.700']   ?? "") . "\t" .
                    ($item['fields']['Fields.1041']   ?? "") . "\t" .
                    ($item['fields']['Fields.16']   ?? "") . "\t" .
                    ($item['fields']['Fields.19']   ?? "") . "\t" .
                    ($item['fields']['Fields.353']   ?? "") . "\t" .
                    ($item['fields']['Fields.742']   ?? "") . "\t" .
                    ($item['fields']['Fields.2977']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.2365']) ? date('m/d/Y', strtotime($item['fields']['Fields.2365'])) : "") . "\t" .
                    ($item['fields']['Fields.2364']   ?? "") . "\t" .
                    ($item['fields']['Fields.541']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.NOTICES.X96']) ? date('m/d/Y', strtotime($item['fields']['Fields.NOTICES.X96'])) : "") . "\t" .
                    ($item['fields']['Fields.2363']   ?? "") . "\t" .
                    ($item['fields']['Fields.Document.Company.Flood Certificate']   ?? "") . "\t" .
                    ($item['fields']['Fields.Document.Company.Mortgate Insurance']   ?? "") . "\t" .
                    ($item['fields']['Fields.1612']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.1402']) ? date('m/d/Y', strtotime($item['fields']['Fields.1402'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1403']) ? date('m/d/Y', strtotime($item['fields']['Fields.1403'])) : "") . "\t" .
                    ($item['fields']['Fields.13']   ?? "") . "\t" .
                    ($item['fields']['Fields.2364']   ?? "") . "\t" .
                    ($item['fields']['Fields.430']   ?? "") . "\t" .
                    ($item['fields']['Fields.ULDD.FNM.X50']   ?? "") . "\t" .
                    ($item['fields']['Fields.3533']   ?? "") . "\t" .
                    ($item['fields']['Fields.4000#2']   ?? "") . "\t" .
                    ($item['fields']['Fields.4002#2']   ?? "") . "\t" .
                    ($item['fields']['Fields.4001#2']   ?? "") . "\t" .
                    ($item['fields']['Fields.65#2']   ?? "") . "\t" .
                    ($item['fields']['Fields.4000#3']   ?? "") . "\t" .
                    ($item['fields']['Fields.4002#3']   ?? "") . "\t" .
                    ($item['fields']['Fields.4001#3']   ?? "") . "\t" .
                    ($item['fields']['Fields.65#3']   ?? "") . "\t" .
                    ($item['fields']['Fields.4000#4']   ?? "") . "\t" .
                    ($item['fields']['Fields.4002#4']   ?? "") . "\t" .
                    ($item['fields']['Fields.4001#4']   ?? "") . "\t" .
                    ($item['fields']['Fields.65#4']   ?? "") . "\t" .
                    ($item['fields']['Fields.66#2']   ?? "") . "\t" .
                    ($item['fields']['Fields.66#3']   ?? "") . "\t" .
                    ($item['fields']['Fields.66#4']   ?? "") . "\t" .
                    ($item['fields']['Fields.2973']   ?? "") . "\t" .
                    ($item['fields']['Fields.109']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.3548']) ? date('m/d/Y', strtotime($item['fields']['Fields.3548'])) : "") . "\t" .
                    ($item['fields']['Fields.3336']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.78']) ? (date('m/d/Y', strtotime(strtok($item['fields']['Fields.78'], " ") . '+1 day'))) : "") . "\t" .
                    ($item['fields']['Fields.VEND.X167']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X337']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X338']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X339']   ?? "") . "\t" .
                    ($item['fields']['Fields.NEWHUD.X1726']   ?? "") . "\t" .
                    ($item['fields']['Fields.1040']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.334']) ? (str_replace(',', '', $item['fields']['Fields.334'])) : "") . "\t" .
                    (isset($item['fields']['Fields.454']) ? (str_replace(',', '', $item['fields']['Fields.454'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1045']) ? (str_replace(',', '', $item['fields']['Fields.1045'])) : "") . "\t" .
                    ($item['fields']['Fields.362']   ?? "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.Account Manager']   ?? "") . "\t" .
                    ($item['fields']['Fields.1039']   ?? "") . "\t" .
                    ($item['fields']['Fields.409']   ?? "") . "\t" .
                    ($item['fields']['Fields.1093']   ?? "") . "\t" .
                    ($item['fields']['Fields.3656']   ?? "") . "\t" .
                    ($item['fields']['Fields.3657']   ?? "") . "\t" .
                    ($item['fields']['Fields.3658']   ?? "") . "\t" .
                    ($item['fields']['Fields.1059']   ?? "") . "\t" .
                    ($item['fields']['Fields.NOTICES.X50']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.3514']) ? date('m/d/Y', strtotime($item['fields']['Fields.3514'])) : "") . "\t" .
                    ($item['fields']['Fields.LoanTeamMember.Name.File Starter']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.CX.HUD0141']) ? date('m/d/Y', strtotime($item['fields']['Fields.CX.HUD0141'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.HUD0142']) ? date('m/d/Y', strtotime($item['fields']['Fields.CX.HUD0142'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.HUD0241']) ? date('m/d/Y', strtotime($item['fields']['Fields.CX.HUD0241'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.HUD0242']) ? date('m/d/Y', strtotime($item['fields']['Fields.CX.HUD0242'])) : "") . "\t" .
                    (isset($item['fields']['Fields.2370']) ? date('m/d/Y', strtotime($item['fields']['Fields.2370'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1997']) ? date('m/d/Y', strtotime($item['fields']['Fields.1997'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.HUD0144']) ? date('m/d/Y', strtotime($item['fields']['Fields.CX.HUD0144'])) : "") . "\t" .
                    (isset($item['fields']['Fields.CX.HUD0244']) ? date('m/d/Y', strtotime($item['fields']['Fields.CX.HUD0244'])) : "") . "\t" .
                    ($item['fields']['Fields.1894']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.2397']) ? date('m/d/Y', strtotime($item['fields']['Fields.2397'])) : "") . "\t" .
                    ($item['fields']['Fields.VEND.X150']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X151']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X152']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X529']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X530']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X532']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X533']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X534']   ?? "") . "\t" .
                    ($item['fields']['Fields.VEND.X536']   ?? "") . "\t" .
                    (isset($item['fields']['Fields.CX.WC.PMI.PAID.BY']) ? (str_replace(',', '', $item['fields']['Fields.CX.WC.PMI.PAID.BY'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1888']) ? (str_replace(',', '', $item['fields']['Fields.1888'])) : "") . "\t" .
                    (isset($item['fields']['Fields.1483']) ? (str_replace(',', '', $item['fields']['Fields.1483'])) : "") . "\t" .
                    (isset($item['fields']['Fields.2211']) ? (str_replace(',', '', $item['fields']['Fields.2211'])) : "") . "\n";
            }
            Storage::disk('local')->append('encompass_report.txt', $encompass_report, null);
            Storage::disk('local')->append('encompass_buyside.txt', $encompass_buyside, null);
            Storage::disk('local')->append('subservicing_data.txt', $subservicing_data, null);
        }

        $temp1 = Storage::disk('local')->get('encompass_report.txt');
        $temp2 = Storage::disk('local')->get('encompass_buyside.txt');
        $temp3 = Storage::disk('local')->get('subservicing_data.txt');

        Storage::disk('ftp')->put('encompass_report.txt', $temp1);
        Storage::disk('ftp')->put('encompass_buyside.txt', $temp2);
        Storage::disk('ftp')->put('subservicing_data.txt', $temp3);

        $test = new TeamsNotificationController;
        $test->notificationForLoanInfo();
    }


    public function failed()
    {
        $test = new TeamsNotificationController;
        $test->notificationForFailed();
    }
}
