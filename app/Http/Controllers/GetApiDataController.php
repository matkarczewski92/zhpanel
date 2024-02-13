<?php

namespace App\Http\Controllers;

use App\Interfaces\ApiDataRepositoryInterface;

class GetApiDataController extends Controller
{
    private $ip;
    private ApiDataRepositoryInterface $apiRepo;

    public function __invoke(ApiDataRepositoryInterface $apiRepo)
    {
        $this->apiRepo = $apiRepo;

        return view('apiData', [
            'data' => $apiRepo->apiGetData('heatings'),
        ]);
    }
}
