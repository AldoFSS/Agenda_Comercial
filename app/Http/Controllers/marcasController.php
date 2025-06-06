<?php

namespace App\Http\Controllers;

use App\Models\marcas;
use Illuminate\Http\Request;

class marcasController
{
    public function MostrarMarcas()
    {
        $marcas = marcas::where('estatus', '=', '1')->get();

        return view('paginas.marcas', compact('marcas'));
    }
    public function crearMarca(Request $request)
    {
        $validated = $request->validate([
            'nombre_marca'=>'required|string|max:255',
            'descripcion_marca'=>'required|string|max:255'
        ]);

        $marca = marcas::create([
            'nombre_marca' => $validated['nombre_marca'],
            'descripcion_marca' => $validated['descripcion_marca']
        ]);
         return redirect()->route('marcas')->with('success','Marca creado correctamente');

    }
    public function modificarMarca(Request $request, $id)
    {
        $marca = marcas::findOrFail($id);

        $request->validate([
            'nombre_marca'=>'required|string|max:255',
            'descripcion_marca'=>'required|string|max:255'
        ]);

        $marca->update([
            'nombre_marca'=> $request->nombre_marca,
            'descripcion_marca' => $request->descripcion_marca
        ]);
         return redirect()->back()->with('success', 'Marca actualizado correctamente');

    }
}
