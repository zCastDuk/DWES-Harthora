<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('forms.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (! Auth::attempt($data, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'El correo o la contraseña no son correctos.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $route = match ($request->user()->roles()) {
            'client' => 'properties',
            'commercial' => 'commercial.dashboard',
            'financial' => 'financial.dashboard',
            'management' => 'management.dashboard',
            default      => 'home',
        };

        return redirect()->route($route);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
