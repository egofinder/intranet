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

class GetTPOInfoJob implements ShouldQueue
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
        Storage::disk('local')->delete('outputtpo.txt');
        $output_TPO =
            "orgtype" . "\t" .
            "orgname" . "\t" .
            "disabled" . "\t" .
            "orgid" . "\t" .
            "ownername" . "\t" .
            "complegal" . "\t" .
            "addresss" . "\t" .
            "city" . "\t" .
            "state" . "\t" .
            "zip" . "\t" .
            "phonenum" . "\t" .
            "faxnum" . "\t" .
            "email" . "\t" .
            "website" . "\t" .
            "ratesheet" . "\t" .
            "ratesheetfax" . "\t" .
            "lockinfoemail" . "\t" .
            "lockinfofax" . "\t" .
            "eppsuser" . "\t" .
            "eppscomp" . "\t" .
            "currentstat" . "\t" .
            "watchlist" . "\t" .
            "currentstatus" . "\t" .
            "approved" . "\t" .
            "application" . "\t" .
            "primarysales" . "\t" .
            "primarysalesname" . "\t" .
            "incorp" . "\t" .
            "stateincorp" . "\t" .
            "dateincorp" . "\t" .
            "entitytype" . "\t" .
            "otherentity" . "\t" .
            "taxid" . "\t" .
            "ssnformat" . "\t" .
            "nmls" . "\t" .
            "financials" . "\t" .
            "financialsupdate" . "\t" .
            "companyworth" . "\t" .
            "eoexpire" . "\t" .
            "eocompany" . "\t" .
            "eopolicy" . "\t" .
            "mers" . "\t" .
            "du" . "\t" .
            "canfund" . "\t" .
            "canclose" . "\t" .
            "TPO ID" . "\t" .
            "externalid";

        Storage::disk('local')->put('outputtpo.txt', $output_TPO);

        for ($i = 0; $i <= 3; $i++) {

            $index = $i * 500;
            $response = Http::acceptJson()->withToken($access_token)->get('https://api.elliemae.com/encompass/v3/externalOrganizations/tpos?Limit=500&start=' . $index);
            $decoded = json_decode($response->body(), true);
            $sample = collect($decoded);

            foreach ($sample as $item) {
                $output_TPO = null;
                $output_TPO =
                    $item['basicInfo']['organizationType'] . "\t" .
                    $item['basicInfo']['organizationName'] . "\t" .
                    ($item['basicInfo']['isLoginDisabled'] ? "True" : "False") . "\t" .
                    ($item['basicInfo']['orgId'] ?? "") . "\t" .
                    ($item['basicInfo']['companyOwnerName'] ?? "") . "\t" .
                    ($item['basicInfo']['companyLegalName'] ?? "") . "\t" .
                    ($item['basicInfo']['address']['street1'] ?? "") . "\t" .
                    ($item['basicInfo']['address']['city'] ?? "") . "\t" .
                    ($item['basicInfo']['address']['state'] ?? "") . "\t" .
                    ($item['basicInfo']['address']['zip'] ?? "") . "\t" .
                    ($item['basicInfo']['phoneNumber'] ?? "") . "\t" .
                    ($item['basicInfo']['faxNumber'] ?? "") . "\t" .
                    ($item['basicInfo']['email'] ?? "") . "\t" .
                    ($item['basicInfo']['website'] ?? "") . "\t" .
                    ($item['basicInfo']['rateLockInfo']['rateSheetEmail'] ?? "") . "\t" .
                    ($item['basicInfo']['rateLockInfo']['rateSheetFax'] ?? "") . "\t" .
                    ($item['basicInfo']['rateLockInfo']['lockInfoEmail'] ?? "") . "\t" .
                    ($item['basicInfo']['rateLockInfo']['lockInfoFax'] ?? "") . "\t" .
                    ($item['basicInfo']['productAndPricing']['eppsUserName'] ?? "") . "\t" .
                    ($item['basicInfo']['productAndPricing']['eppsCompModel'] ?? "") . "\t" .
                    ($item['basicInfo']['approvalStatus']['currentStatus'] ?? "") . "\t" .
                    ($item['basicInfo']['approvalStatus']['addToWatchlist'] ? "True" : "False") . "\t" .
                    ($item['basicInfo']['approvalStatus']['currentStatusDate'] ?? "") . "\t" .
                    ($item['basicInfo']['approvalStatus']['approvedDate'] ?? "") . "\t" .
                    ($item['basicInfo']['approvalStatus']['applicationDate'] ?? "") . "\t" .
                    ($item['basicInfo']['primarySalesRepAe']['userId'] ?? "") . "\t" .
                    ($item['basicInfo']['primarySalesRepAe']['name'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['isIncorporated'] ? "True" : "False") . "\t" .
                    ($item['basicInfo']['businessInformation']['stateOfIncorporation'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['dateOfIncorporation'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['typeOfEntity'] ?? "") . "\t" .
                    "Other Entity Description" . "\t" .
                    ($item['basicInfo']['businessInformation']['taxId'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['useSsnFormat'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['nmlsId'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['financialsPeriod'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['financialsLastUpdate'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['companyNetWorth'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['eoExpirationDate'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['eoCompany'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['eoPolicyNumber'] ?? "") . "\t" .
                    ($item['basicInfo']['businessInformation']['mersOriginatingOrgId'] ?? "") . "\t" .
                    "DU Sponsored" . "\t" .
                    (isset($item['basicInfo']['businessInformation']['canFundInOwnName']) ? ($item['basicInfo']['businessInformation']['canFundInOwnName']) : "") . "\t" .
                    (isset($item['basicInfo']['businessInformation']['canCloseInOwnName']) ? ($item['basicInfo']['businessInformation']['canCloseInOwnName']) : "") . "\t" .
                    ($item['basicInfo']['tpoId'] ?? "") . "\t" .
                    ($item['basicInfo']['id'] ?? "");

                Storage::disk('local')->append('outputtpo.txt', $output_TPO);
            }
        }
        Storage::disk('ftp')->put('outputtpo.txt', Storage::disk('local')->get('outputtpo.txt'));
        $test = new TeamsNotificationController;
        $test->notificationForTPO();
    }
}
