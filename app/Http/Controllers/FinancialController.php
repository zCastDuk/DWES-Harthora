<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FinancialController extends Controller
{
    public function show():View
    {
        return view('workers.dashboard');
    }
}
