<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MassDataController extends Controller
{
    public function index()
    {
        return view('mass-data');
    }
}
