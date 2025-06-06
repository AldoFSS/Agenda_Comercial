<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsuariosController
{
    public function index()
    {
        $usuarios = usuarios::where('estatus',1)->get();
        return view('paginas.usuarios', compact('usuarios'));
    }
   public function crearUsuario(Request $request) 
   {
    $validated = $request->validate([
        'nombre_usuario' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'correo' => 'required|email|max:255',
        'rol' => 'required|string|max:50',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'contraseña' => 'required|string|max:255',
    ]);

    try {
        $nombreImagen = null;
        
        if($request->hasFile('imagen')){
           $file = $request->file('imagen');
           $nombreImagen = time().'_'.$file->getClientOriginalName();
           $file->move(public_path('imgUsuario'),$nombreImagen);
        }
        $usuario = usuarios::create([
            'nombre_usuario' => $validated['nombre_usuario'],
            'telefono' => $validated['telefono'],
            'correo' => $validated['correo'],
            'rol' => $validated['rol'],
            'imagen' => $nombreImagen,
            'contraseña' => sha1($validated['contraseña'])
        ]);
        return redirect()->back()->with('success', 'Usuario creado correctamente');

        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with(
                    'error','El correo o el nombre de usuario ya está registrado.'
                );
            }
            return redirect()->back()->withInput()->withErrors([
                'general' => 'Ocurrió un error al crear el usuario.'
            ]);
        }
    }
    public function updateUsuario(Request $request, $id)
    {
        $Usuario = usuarios::findOrFail($id);
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rol' => 'required|string|max:50',
        ]);

        try{
            $datosActualizados = [
            'nombre_usuario' => $request->nombre_usuario,
            'telefono' => $request->telefono,
            'correo'=>$request->correo,
            'rol'=>$request->rol,
        ];

        if($request->hasFile('imagen')){
            if($Usuario->imagen){
                $rutaImagen = public_path('imgUsuario/'.$Usuario->imagen);
                if(file_exists($rutaImagen)){
                    @unlink($rutaImagen);
                }
            }
            $file = $request->file('imagen');
            $nombreImagen = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('imgUsuario'),$nombreImagen);
            $datosActualizados['imagen'] = $nombreImagen;
        }
        $Usuario->update($datosActualizados);
        return redirect()->back()->with('success', 'Usuario actualizado correctamente');
        }catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with(
                    'error','El correo o el nombre de usuario ya está registrado.'
                );
            }
            return redirect()->back()->withInput()->withErrors([
                'general' => 'Ocurrió un error al crear el usuario.'
            ]);
        }
        
    }
    public function eliminarUsuario($idUsuario)
    {
       $usuario = usuarios::find($idUsuario);
       if(!$idUsuario){
        return redirect()->back()->with('error', 'Usuario no encontrado.');
       }
       $usuario->estatus=0;
       $usuario->save();
       return redirect()->back()->with('success', 'Usuario desactivado exitosamente.');
    }
    public function Buscarusuario(Request $request)
    {
        $credenciales = $request->only('nombre_usuario', 'contraseña');

        $usuario = usuarios::where('nombre_usuario', $credenciales['nombre_usuario'])->first();

        if ($usuario && sha1($credenciales['contraseña']) === $usuario->contraseña) {
            Auth::login($usuario); 
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'nombre_usuario' => 'Usuario o contraseña incorrectos',
        ]);
    }
}
