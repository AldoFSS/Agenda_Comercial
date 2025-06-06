<?php

namespace App\Http\Controllers;

use App\Models\zonas;
use Illuminate\Http\Request;

class zonasController
{
    public function MostrarZonas(){
        $zonas = zonas::where('estatus','=', '1')->get();

        return view('paginas.zonas', compact('zonas'));
    }
    public function crearZona(Request $request)
    {
        $request->validate([
            'nombre_zona'=>'required|string|max:255',
            'descripcion_zona' => 'required|string|max:255'
        ]);
        $zona =  zonas::create([
            'nombre_zona' => $request->nombre_zona,
            'descripcion_zona' => $request->descripcion_zona
        ]);
        return redirect()->route('zonas')->with('success','Zona creado correctamente');
    }
    public function modificarZona(Request $request, $id)
    {
        $zona = zonas::findOrFail($id);

        $request->validate([
            'nombre_zona'=>'required|string|max:255',
            'descripcion_zona' => 'required|string|max:255'
        ]);
        $zona->update([
            'nombre_zona' => $request->nombre_zona,
            'descripcion_zona' => $request->descripcion_zona
        ]);
        return redirect()->back()->with('success', 'Zona actualizado correctamente');

    }
}
