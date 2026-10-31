<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CommercialController extends Controller
{
    public function show(): View
    {
        return view('workers.dashboard');
    }
}
