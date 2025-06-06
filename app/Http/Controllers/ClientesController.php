<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\estados;
use App\Models\municipios;
use Illuminate\Http\Request;

class ClientesController 
{
    public function mostrarClientes()
    {
        $clientes = cliente::select([
            'cliente.*',
            'estados.nombre_estado as Estado',
            'municipios.municipio as Municipio'
        ])
        ->join('estados','cliente.id_estado','=','estados.id_estado')
        ->join('municipios','cliente.id_municipio','=','municipios.id_municipio')
        ->where('cliente.estatus','=',1)
        ->get();
        $estados = estados::where('estatus',1)->get();
        return view('paginas.clientes', compact('clientes','estados'));
    }
    public function crearCliente(Request $request) 
    {
        $validated = $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'nombre_comercial' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'rol' => 'required|string|max:255',
            'codigo_postal' => 'required|numeric',
            'colonia' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'id_estado' => 'required|exists:estados,id_estado',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $nombreImagen = null;
            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $nombreImagen = time().'_'.$file->getClientOriginalName();
                if (!file_exists(public_path('imgCliente'))) {
                    mkdir(public_path('imgCliente'), 0755, true);
                }
                $file->move(public_path('imgCliente'), $nombreImagen);
            }

            $cliente = Cliente::create([
                'nombre_cliente' => $validated['nombre_cliente'],
                'nombre_comercial' => $validated['nombre_comercial'],
                'telefono' => $validated['telefono'],
                'correo' => $validated['correo'],
                'rol' => $validated['rol'],
                'codigo_postal' => $validated['codigo_postal'],
                'colonia' => $validated['colonia'],
                'calle' => $validated['calle'],
                'id_estado' => $validated['id_estado'],
                'id_municipio' => $validated['id_municipio'],
                'imagen' => $nombreImagen,
            ]);

            return redirect()->route('clientes')->with('success', 'Cliente creado correctamente');
        } catch (\Exception $e) {
            return back()->withErrors('Ocurrió un error al crear el cliente: ' . $e->getMessage());
        }
    }

    public function actualizarCliente(Request $request, $id)
    {
        $Cliente = cliente::findOrFail($id);

        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'nombre_comercial' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'rol' => 'required|string|max:255',
            'codigo_postal' => 'required|numeric',
            'colonia' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'id_estado' => 'required|exists:estados,id_estado',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $datosActualizados =[
            'nombre_cliente' => $request['nombre_cliente'],
            'nombre_comercial' => $request['nombre_comercial'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'rol' => $request['rol'],
            'codigo_postal' => $request['codigo_postal'],
            'colonia' => $request['colonia'],
            'calle' => $request['calle'],
            'id_estado' => $request['id_estado'],
            'id_municipio' => $request['id_municipio'],
        ];
        if($request->hasFile('imagen')){
            if($Cliente->imagen){
                $rutaImagen = public_path('imagen/'.$Cliente->imagen);
                if(file_exists($rutaImagen)){
                    @unlink($rutaImagen);
                }
            }
            $file = $request->file('imagen');
            $nombreImagen = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('imgCliente'),$nombreImagen);
            $datosActualizados['imagen'] = $nombreImagen;
        }
        $Cliente->update($datosActualizados);
        return redirect()->back()->with('success', 'Cliente actualizado correctamente');
    }
    public function BuscarMunicipio($id_estado)
    {
        $municipios = municipios::select('id_municipio','municipio')
        ->where('id_estd',$id_estado)
        ->get();
        return response()->json($municipios);
    }
}
