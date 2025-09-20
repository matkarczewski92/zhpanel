<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LittersPlanningFormController extends Controller
{
    public function index()
    {
        return view('litters-planning-form');
    }
}
