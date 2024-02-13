<?php

namespace App\Interfaces;

interface ApiDataRepositoryInterface
{
    public function apiLogin();

    public function apiLogout();

    public function apiGetData(string $api);

    public function apiPostData();

    public function apiPutData();

    public function apiDeleteData();
}
