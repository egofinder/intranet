<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\EncompassReport
 *
 * @property int $UID
 * @property string $TransDetailsApplicationDate
 * @property string $PurchaseAdviceDate
 * @property string $TransDetailsLoan
 * @property string $BorrowerFirstName
 * @property string $BorrowerLastName
 * @property string $InvestorCaseLoan
 * @property string $SubjectPropertyAddress
 * @property string $SubjectPropertyCity
 * @property string $SubjectPropertyState
 * @property string $SubjectPropertyZip
 * @property string $FileContactsInvestorName
 * @property string $WarehouseCoName
 * @property string $RateLockBuySideBasePriceRate
 * @property string $BuySidePriceTotAdjustment
 * @property string $NetBuyPrice
 * @property string $NetSellRate
 * @property string $BaseSellPrice
 * @property string $SellSidePriceTotAdjustment
 * @property string $RateLockSellSideNetSellPrice
 * @property string $SellSideSRPPaidOut
 * @property string $SellSideDiscountYSP
 * @property string $RateLockSellSideInvestorDeliveryDate
 * @property string $RateLockSellSideTargetDeliveryDate
 * @property string $RateLockSellSideTotalSellPrice
 * @property string $GainLossPercent
 * @property string $GainLossAmount
 * @property string $TotalLoanAmount
 * @property string $TotalWireTransfer
 * @property string $LoanStatus
 * @property string $FundsSentDate
 * @property string $ShippingDate
 * @property string $Occupancy
 * @property string $BorrPresentAddr
 * @property string $BorrPresentCity
 * @property string $BorrPresentState
 * @property string $BorrPresentZip
 * @property string $LastFinishedMilestone
 * @property string $BorrEmail
 * @property string $LoanType
 * @property string $RateLockBuySideTotalBuyPrice
 * @property string $RateLockSellSideBasePriceAdjust1Desc
 * @property string $RateLockSellSideBasePriceAdjust1Rate
 * @property string $RateLockSellSideBasePriceAdjust2Desc
 * @property string $RateLockSellSideBasePriceAdjust2Rate
 * @property string $RateLockSellSideBasePriceAdjust3Desc
 * @property string $RateLockSellSideBasePriceAdjust3Rate
 * @property string $RateLockSellSideBasePriceAdjust4Desc
 * @property string $RateLockSellSideBasePriceAdjust4Rate
 * @property string $RateLockSellSideBasePriceAdjust5Desc
 * @property string $RateLockSellSideBasePriceAdjust5Rate
 * @property string $RateLockSellSideBasePriceAdjust6Desc
 * @property string $RateLockSellSideBasePriceAdjust6Rate
 * @property string $RateLockSellSideBasePriceAdjust7Desc
 * @property string $RateLockSellSideBasePriceAdjust7Rate
 * @property string $BrokerLenderName
 * @property string $PIPaymentAmount
 * @property string $MortgageInsuranceAmount
 * @property string $EstimatedEscrowAmount
 * @property string $BorrHomePhone
 * @property string $Underwriter
 * @property string $FirstPmtDate
 * @property string $Shipper
 * @property string $TeamMember
 * @property string $SetUpDate
 * @property string $LienPosition
 * @property string $DocPrepDate
 * @property string $DocDrawnBy
 * @property string $ClearToCloseDate
 * @property string $ClearForDocsDate
 * @property string $UnitNumber
 * @property string $FHACase
 * @property string $CountyName
 * @property string $LoanPurpose
 * @property string $MilestoneDate
 * @property string $BorrMailingAddr
 * @property string $BorrMailingCity
 * @property string $BorrMailingState
 * @property string $BorrMailingZip
 * @property string $BorrMailingCheck
 * @property string $DocReturnDate
 * @property string $TPOCompanyAEName
 * @property string $TPOCompanyName
 * @property string $TPOPhone
 * @property string $LoanProgram
 * @property string $LockExpireDate
 * @property string $TPOEmail
 * @property string $Channel
 * @property string $FundingType
 * @property string $DecisionDate
 * @property string $FinalApprovalDate
 * @property string $OrgID
 * @property string $OrgIDMap
 * @property string $LEDueDate
 * @property string $LESentDate
 * @property string $FileStarterEmail
 * @property string $LoanOfficerEmail
 * @property string $FileStarterName
 * @property string $LoanOfficerName
 * @property string $ProcessingDate
 * @property string $PreApproveDate
 * @property string $DocType
 * @property int $DaysSetUp
 * @property int $DaysPreApprove
 * @property int $DaysDecision
 * @property int $DaysPTD
 * @property int $DaysClearDocs
 * @property int $DaysDocPrep
 * @property int $DaysDocReturn
 * @property int $DaysFinalApprove
 * @property int $DaysClosing
 * @property int $DaysFunding
 * @property int $DaysSuspense
 * @property int $DaysPurchase
 * @property string $PTDDate
 * @property string $RateLockSellSideBasePriceAdjust8Desc
 * @property string $RateLockSellSideBasePriceAdjust8Rate
 * @property string $RateLockSellSideBasePriceAdjust9Desc
 * @property string $RateLockSellSideBasePriceAdjust9Rate
 * @property string $RateLockSellSideBasePriceAdjust10Desc
 * @property string $RateLockSellSideBasePriceAdjust10Rate
 * @property string $AccountManager
 * @property string $JrUnderwriter
 * @property string $EscrowPaymentDate
 * @property string $EscrowPaymentType
 * @property string $EscrowPaymentName
 * @property string $EscrowPaymentAmount
 * @property string $Fees1000Total
 * @property string $TPOAEBranchName
 * @property string $CurrentStatusDate
 * @property string $FundingDate
 * @property string $APR
 * @property string $LoanOfficerNMLS
 * @property string $EscrowPaymentDate1
 * @property string $EscrowPaymentType1
 * @property string $EscrowPaymentName1
 * @property string $EscrowPaymentAmount1
 * @property string $Funder
 * @property string $DisclosureFullfilledBy
 * @property string $DisclosureDateTimeSent
 * @property string $EscrowPaymentDate2
 * @property string $EscrowPaymentType2
 * @property string $EscrowPaymentName2
 * @property string $EscrowPaymentAmount2
 * @property string $EscrowPaymentDate3
 * @property string $EscrowPaymentType3
 * @property string $EscrowPaymentName3
 * @property string $EscrowPaymentAmount3
 * @property string $EscrowPaymentDate4
 * @property string $EscrowPaymentType4
 * @property string $EscrowPaymentName4
 * @property string $EscrowPaymentAmount4
 * @property string $ShippingCoordinator
 * @property string $SuspenseCoordinator
 * @property string $QCShippingReadyBy
 * @property string $QCShippingReadyDate
 * @property string $ClosingPackageDate
 * @property string $DisclosureConditionClearedBy
 * @property string $DisclosureConditionClearedDate
 * @property string $EstimatedEscrow1
 * @property string $QCReviewType1
 * @property string $QCReviewType2
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereAPR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereAccountManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBaseSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrHomePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrMailingAddr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrMailingCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrMailingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrMailingState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrMailingZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrPresentAddr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrPresentCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrPresentState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrPresentZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrowerFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBorrowerLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBrokerLenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereBuySidePriceTotAdjustment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereClearForDocsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereClearToCloseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereClosingPackageDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereCountyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereCurrentStatusDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysClearDocs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysClosing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysDecision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysDocPrep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysDocReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysFinalApprove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysFunding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysPTD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysPreApprove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysSetUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDaysSuspense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDecisionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDisclosureConditionClearedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDisclosureConditionClearedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDisclosureDateTimeSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDisclosureFullfilledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDocDrawnBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDocPrepDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDocReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereDocType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentAmount1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentAmount2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentAmount3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentAmount4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentDate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentDate3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentDate4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentName1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentName2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentName3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentName4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentType1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentType2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentType3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEscrowPaymentType4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEstimatedEscrow1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereEstimatedEscrowAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFHACase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFees1000Total($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFileContactsInvestorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFileStarterEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFileStarterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFinalApprovalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFirstPmtDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFunder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFundingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFundingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereFundsSentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereGainLossAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereGainLossPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereInvestorCaseLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereJrUnderwriter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLEDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLESentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLastFinishedMilestone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLienPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLoanOfficerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLoanOfficerNMLS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLoanOfficerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLoanProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLoanPurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLoanStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLoanType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereLockExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereMilestoneDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereMortgageInsuranceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereNetBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereNetSellRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereOccupancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereOrgID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereOrgIDMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport wherePIPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport wherePTDDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport wherePreApproveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereProcessingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport wherePurchaseAdviceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereQCReviewType1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereQCReviewType2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereQCShippingReadyBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereQCShippingReadyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockBuySideBasePriceRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockBuySideTotalBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust10Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust10Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust1Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust1Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust2Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust2Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust3Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust3Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust4Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust4Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust5Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust5Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust6Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust6Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust7Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust7Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust8Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust8Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust9Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideBasePriceAdjust9Rate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideInvestorDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideNetSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideTargetDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereRateLockSellSideTotalSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSellSideDiscountYSP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSellSidePriceTotAdjustment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSellSideSRPPaidOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSetUpDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereShipper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereShippingCoordinator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereShippingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSubjectPropertyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSubjectPropertyCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSubjectPropertyState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSubjectPropertyZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereSuspenseCoordinator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTPOAEBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTPOCompanyAEName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTPOCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTPOEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTPOPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTeamMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTotalLoanAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTotalWireTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTransDetailsApplicationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereTransDetailsLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereUID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereUnderwriter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereUnitNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EncompassReport whereWarehouseCoName($value)
 */
	class EncompassReport extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentLetter
 *
 * @property int $UID
 * @property int $TID
 * @property string $PACLOAN
 * @property string $INVESTORLOAN
 * @property string $PrincipalInterest
 * @property string $Impound
 * @property string $MonthlyPremium
 * @property string $BuyDown
 * @property string $Total
 * @property string $PaymentDate
 * @property string $DATE
 * @property string $RECEIVED
 * @property int $PATID
 * @property string $CheckNum
 * @property string $CheckImage
 * @property string $Payment
 * @property string $Note
 * @property string $AddImage
 * @property string $FirstNotice
 * @property string $SecondNotice
 * @property string $DEL
 * @property int $AID
 * @property int $EncompassIMPORT
 * @property int $NextGen
 * @property int $MonthlyPremiumImport
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereAID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereAddImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereBuyDown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereCheckImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereCheckNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereDEL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereEncompassIMPORT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereFirstNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereINVESTORLOAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereImpound($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereMonthlyPremium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereMonthlyPremiumImport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereNextGen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter wherePACLOAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter wherePATID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter wherePrincipalInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereRECEIVED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereSecondNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereTID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLetter whereUID($value)
 */
	class PaymentLetter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $UserID
 * @property string $EmailAddress
 * @property string $FirstName
 * @property string $LastName
 * @property string $Extension
 * @property string $Corporation
 * @property string $Division
 * @property string $Branch
 * @property string $Department
 * @property int $Active
 * @property int $Exempt 0 exe, 1 non
 * @property int $eID
 * @property string $AccountID
 * @property int $Interval
 * @property string $KillClock
 * @property string $KillComputer KILLS USER COMPUTER
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCorporation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereExempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereKillClock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereKillComputer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserID($value)
 */
	class User extends \Eloquent {}
}

