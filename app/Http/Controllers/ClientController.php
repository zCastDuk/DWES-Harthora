<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ClientController extends Controller
{
    public function show(): View
    {
        return view('profile.show');
    }
}
