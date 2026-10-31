<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index():View
    {
        $properties = Property::with('zone')
            ->latest('published_at')
            ->paginate(12);

        return view('catalogo.index', ['properties' => $properties]);
    }

    public function show(Property $property):View
    {
        $property->load(['zone', 'features']);

        return view('catalogo.show', ['property' => $property]);
    }
}
