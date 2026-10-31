<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FinancialController extends Controller
{
    public function show(): View
    {
        return view('workers.dashboard');
    }
}
