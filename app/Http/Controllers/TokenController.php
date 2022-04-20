<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Token;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestExport;

class TokenController extends Controller
{
    public function getToken()
    {
        $response = Http::asForm()
            ->post(
                'https://api.elliemae.com/oauth2/v1/token',
                [
                    'grant_type' => 'password',
                    'username' => 'benjaminj@encompass:BE799207',
                    'password' => 'EEQorzkrl1324!',
                    'client_id' => 'thq12xx',
                    'client_secret' => 'cx7mMw15qJ1j7o$YbyaFM5VfY4KLUIVRN*HEENj7&N!b*h$&IVfc$593l@CG832^'
                ]
            );
        // dd($response->body());
        $decoded = json_decode($response->body(), true);
        $access_token = $decoded['access_token'];
        $token_type = $decoded['token_type'];

        $token = Token::find(1);
        $token->access_token = $access_token;
        $token->token_type = $token_type;
        $token->save();
        // return $access_token;
    }


    public function introspectToken()
    {
        $token = Token::find(1);


        $response = Http::asForm()
            ->post(
                'https://api.elliemae.com/oauth2/v1/token/introspection',
                [
                    'client_id' => 'thq12xx',
                    'client_secret' => 'cx7mMw15qJ1j7o$YbyaFM5VfY4KLUIVRN*HEENj7&N!b*h$&IVfc$593l@CG832^',
                    'token' => $token->access_token
                ]
            );
        // dd($response->body());
        $decoded = json_decode($response->body(), true);
        // dd($decoded);
        // if ($decoded['error']) {
        //     $getToken = new TokenController;
        //     $getToken->getToken();
        // }
        // return ($token->access_token);
    }

    public function test()
    {
        $token = Token::find(1);

        dd($token->access_token);
    }

    public function export()
    {
        return Excel::download(new TestExport, 'Token.xlsx');
    }
}
