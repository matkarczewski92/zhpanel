<?php

namespace App\Repository;

use App\Interfaces\ApiDataRepositoryInterface;
use Illuminate\Support\Facades\Http;

class ApiDataRepository implements ApiDataRepositoryInterface
{
    public function __construct()
    {
        $this->apiLogin();
    }

    public function apiLogin()
    {
        if (!session()->has('apiToken')) {
            $ip = systemConfig('zhControllIp');
            $apiToken = systemConfig('apiToken');
            $apiPass = systemConfig('apiPass');

            $response = Http::acceptJson()->asForm()->post('http://'.$ip.'/api/auth/login', [
                'apiToken' => $apiToken,
                'password' => $apiPass,
            ]);

            $loginData = $response->object();
            $auth = $loginData->token_type.' '.$loginData->accessToken;
            session()->put('apiToken', $auth);

            return $auth;
        } else {
            return session('apiToken');
        }
    }

    public function apiLogout()
    {
        if (session()->has('apiToken')) {
            $ip = systemConfig('zhControllIp');
            $auth = session('apiToken');

            $apiUrl = Http::acceptJson()->asForm()->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => $auth,
            ])->get('http://'.$ip.'/api/auth/logout');

            session()->forget('apiToken');
        }
    }

    public function apiGetData(string $api)
    {
        $ip = systemConfig('zhControllIp');
        $auth = session('apiToken');

        $apiUrl = Http::acceptJson()->asForm()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $auth,
        ])->get('http://'.$ip.'/api/auth/'.$api);

        return $apiUrl->collect();
    }

    public function apiPostData()
    {
    }

    public function apiPutData()
    {
    }

    public function apiDeleteData()
    {
    }
}
