<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{

    public function index()
    {
        return Articulo::get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' =>'required|min:4|max:150',
            'descripcion'=> 'required|min:4',
            'stock'=> 'required'
        ]);

        $articulo= new Articulo;
        $articulo->create($request->all());
    }

    public function show(Articulo $articulo)
    {
        return $articulo;
        
    }

    public function update(Request $request, Articulo $articulo)
    {
        $articulo->update($request->all());
    }

    public function destroy(Articulo $articulo)
    {
        $articulo->delete();
    }
}
