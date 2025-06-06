<?php

namespace App\Http\Controllers;

use App\Models\citas;
use App\Models\cliente;
use App\Models\usuarios;
use DB;
use Illuminate\Http\Request;

class CitasController 
{
    public function mostrarCitas()
    {
        $citas = citas::where('estatus',1)->get() ;  
        $clientes = cliente::where('estatus',1)->get();
        $usuarios = usuarios::where('estatus',1)->get();

        return view('paginas.citas', compact('citas', 'clientes', 'usuarios'));
    }

    public function crearCita(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'fecha_cita'=>'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'motivo' => 'required|string|max:255',
        ]);
    
        citas::create([
            'id_cli' => $request->id_cliente,
            'id_usr' => $request->id_usuario,
            'fecha_cita' =>$request->fecha_cita,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'motivo' => $request->motivo,
        ]);
    
        return redirect()->back()->with('success', 'Cita creada correctamente.');
    }
   public function actualizarFecha(Request $request, $id)
   {
    try {
        $data = $request->json()->all();
        citas::where('id_cita', $id)->update([
            'fecha_cita' => $data['fecha_cita'],
            'hora_inicio' => $data['hora_inicio'],
            'hora_fin' => $data['hora_fin']
        ]);
        return response()->json(['mensaje' => 'Cita actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No se pudo actualizar la cita',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }
    public function actualizarCita(Request $request, $id)
    {
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'fecha_cita'=>'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'motivo' => 'required|string|max:255',
        ]);
        $cita = citas::findOrFail($id);
        $cita->update([
            'id_cli' => $request->id_cliente,
            'id_usr' => $request->id_usuario,
            'fecha_cita'=>$request->fecha_cita,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'motivo' => $request->motivo,
        ]);
        return redirect()->back()->with('success', 'Cita actualizada correctamente.');
    }
    public function eliminarCita($idcita)
    {
        $cita = citas::find($idcita);
        if (!$cita) {
            return response()->json(['mensaje' => 'Cita no encontrada.'], 404);
        }
        $cita->estatus = 0;
        $cita->save();
        return response()->json(['mensaje' => 'Cita eliminada exitosamente.']);
    }
    public function obtenerEventos()
    {
        $citas = citas::where('estatus',1)->get();

        $datos = $citas->map(function ($cita) {
            return [
                'id_ct' => $cita->id_cita,
                'id_cli'=>$cita->id_cli,
                'id_usr'=>$cita->id_usr,
                'title' => $cita->motivo,
                'start' => $cita->fecha_cita . 'T' . $cita->hora_inicio,
                'end' => $cita->fecha_cita . 'T' . $cita->hora_fin,
                'color' => '#2324ff'
            ];
        });
        return response()->json($datos);
    }
}
