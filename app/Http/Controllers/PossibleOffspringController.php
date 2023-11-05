<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PossibleOffspringController extends Controller
{

    public function index()
    {
        return view('possible-offspring');
    }
}
