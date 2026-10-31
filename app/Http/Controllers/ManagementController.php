<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ManagementController extends Controller
{
    public function show(): View
    {
        return view('workers.dashboard');
    }
}
