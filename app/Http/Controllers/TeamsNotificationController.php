<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TeamsNotificationController extends Controller
{
    public function notificationForTPO()
    {
        return Http::withBody(
            '{
                "type": "TextBlock",
                "text": "TPO Information text file created,
                Please, go to [Download Page](http://192.168.1.50/download)"
            }',
            'application/json'
        )->post(
            'https://pacbaylending1.webhook.office.com/webhookb2/b627f0f7-ca08-4bb4-821e-58c281de75c8@2cd4783b-5f16-4b96-89ad-8c0292daf5fe/IncomingWebhook/e8f19f4b472a4cb3b40d38af8973d06a/a9681e7c-6c96-4b45-a0d2-75b1fccbaba6',
        );
    }



    public function notificationForLoanInfo()
    {
        return Http::withBody(
            '{
                "type": "TextBlock",
                "text": "Loan Information text file created,
                Please, go to [Download Page](http://192.168.1.50/download)"
            }',
            'application/json'
        )->post(
            'https://pacbaylending1.webhook.office.com/webhookb2/b627f0f7-ca08-4bb4-821e-58c281de75c8@2cd4783b-5f16-4b96-89ad-8c0292daf5fe/IncomingWebhook/e8f19f4b472a4cb3b40d38af8973d06a/a9681e7c-6c96-4b45-a0d2-75b1fccbaba6',
        );
    }


    public function notificationForFailed()
    {
        return Http::withBody(
            '{
                "type": "TextBlock",
                "text": "One of your Request Failed,
                Please, Try Again"
            }',
            'application/json'
        )->post(
            'https://pacbaylending1.webhook.office.com/webhookb2/b627f0f7-ca08-4bb4-821e-58c281de75c8@2cd4783b-5f16-4b96-89ad-8c0292daf5fe/IncomingWebhook/e8f19f4b472a4cb3b40d38af8973d06a/a9681e7c-6c96-4b45-a0d2-75b1fccbaba6',
        );
    }
}
