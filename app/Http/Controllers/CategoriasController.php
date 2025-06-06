<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController
{
    public function MostrarCatalogo()
    {
        $categorias = Categoria::where('estatus',1)->get();
        return view ('paginas.categorias', compact('categorias'));
    }
    public function CrearCategoria(Request $request)
    {
        $validated = $request->validate([
            'nombre_Categoria' => 'required|string|max:20',
            'descripcion'=>'required|string|max:255',
            'imagen_Categoria' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
            $nombreImagen = null;
            if($request->hasFile('imagen_Categoria')){
                $file = $request->file('imagen_Categoria');
                $nombreImagen = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('imgCategoria'),$nombreImagen);
            }
            $categoria = Categoria::create([
                'nombre_Categoria' => $validated['nombre_Categoria'],
                'descripcion' => $validated['descripcion'],
                'imagen_Categoria' => $nombreImagen,
            ]);
            return redirect()->route('categorias')->with('success', 'Categoria creado correctamente');
    }
    public function ModificarCategoria(Request $request, $id){

        $categoria = Categoria::findOrFail($id);
        $request->validate([
            'nombre_Categoria' => 'required|string|max:20',
            'descripcion_categoria'=>'required|string|max:255',
            'imagen_Categoria' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $datosModificados =[
            'nombre_Categoria' => $request->nombre_Categoria,
            'descripcion' => $request->descripcion_categoria
        ];
        
        if($request->hasFile('imagen_Categoria')){
            if($categoria->imagen_Categoria){
                $rutaImagen = public_path('imgCategoria/'.$categoria->imagen_Categoria);
                if(file_exists($rutaImagen)){
                    @unlink($rutaImagen);
                }
            }
            $file = $request->file('imagen_Categoria');
            $nombreImagen = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('imgCategoria'), $nombreImagen);
            $datosModificados['imagen_Categoria'] = $nombreImagen;
        }
        $categoria->update($datosModificados);
        return redirect()->back()->with('success', 'Categoria actualizado correctamente');
    }
    public function eliminarCategoria($idCategoria)
    {
        $categoria = Categoria::findOrFail($idCategoria);
        if($idCategoria){
            return redirect()->back()->with('error', 'Categoria no encontrada.');
       }
       $categoria->estatus=0;
       $categoria->save();
       return redirect()->back()->with('success', 'Categoria desactivada exitosamente.');
       
    }
}
