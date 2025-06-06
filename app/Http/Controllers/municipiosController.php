<?php

namespace App\Http\Controllers;

use App\Models\estados;
use App\Models\municipios;
use Illuminate\Http\Request;

class municipiosController
{
    public function MostrarMunicipios(){
        $municipios = municipios::select([
            'municipios.*',
            'estados.nombre_estado as Estado'
        ])
        ->join('estados', 'municipios.id_estd', '=', 'estados.id_estado')
        ->where('municipios.estatus', '=', '1')
        ->get();

        $estados = estados::where('estatus','=',1)->get();

        return view ('paginas.municipios', compact('municipios','estados'));
    }
    public function CrearMunicipio(Request $request)
    {
        $request->validate([
            'nombre_municipio'=> 'required|string|max:255',
            'id_estado' =>  'required|exists:estados,id_estado'
        ]);
        $municipio = municipios::create([
            'municipio' => $request->nombre_municipio,
            'id_estd' => $request->id_estado
        ]);
        return redirect()->route('municipios')->with('success','Municipio creado correctamente');
    }
    public function EditarMunicipio(Request $request, $id)
    {
        $municipio = municipios::findOrFail($id);

        $request->validate([
            'municipio'=> 'required|string|max:255',
            'id_estado' =>  'required|exists:estados,id_estado'
        ]);
        $municipio->update([
            'municipio' => $request->municipio,
            'id_estd' => $request->id_estado
        ]);

        return redirect()->back()->with('success','Municipio actualizado correctamente');
    }
}
