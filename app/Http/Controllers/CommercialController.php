<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CommercialController extends Controller
{
    public function show():View
    {
        return view('workers.dashboard');
    }
}
