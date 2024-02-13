<?php

namespace App\Http\Controllers;

class ZHCAccessController extends Controller
{
    public function __invoke()
    {
        return redirect('http://'.systemConfig('zhControllIp'));
    }
}
