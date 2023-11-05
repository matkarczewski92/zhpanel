<?php

use App\Models\SystemConfig;



function systemConfig(string $key)
{
    $systemConfig = SystemConfig::where('key', $key)->first();
    // dd($systemConfig);
    return $systemConfig->value;
}
