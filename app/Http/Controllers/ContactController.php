<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index():View
    {
        return view('contact');
    }
    public function store(ContactRequest $request): RedirectResponse
    {
        //Formulario inactivo.
        //En los próximos Sprints se programará el envio de correos
        return redirect()
            ->route('contact')
            ->with('success', 'Gracias por escribirnos. Te responderemos lo antes posible');
    }
}
