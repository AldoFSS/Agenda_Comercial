<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Http\Request;

class SubCategoriasController
{
    public function MostrarSubCategorias()
    {
        $subcategorias = SubCategoria::select([
            'subcategoria.*',
            'categoria.nombre_categoria as Categoria'
        ])
        -> join('categoria', 'subcategoria.id_ctg', '=','categoria.id_categoria')
        ->where('subcategoria.estatus','=','1')
        ->get();

        $categorias = Categoria::where('estatus', 1)->get();

        return view ('paginas.subcategorias', compact('subcategorias','categorias'));
    }
    public function CrearSubCategoria(Request $request)
    {
        $validated = $request->validate([
            'nombre_subcategoria' => 'required|string|max:20',
            'descripcion_subcategoria' =>'required|string|max:255',
            'id_categoria' =>'required|exists:categoria,id_categoria' ,
            'imagen_subcategoria' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
            $nombreImagen = null;
            if($request->hasFile('imagen_subcategoria')){
                $file = $request->file('imagen_subcategoria');
                $nombreImagen = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('imgSubCategoria'),$nombreImagen);
            }
            $subcategoria = SubCategoria::create([
                'nombre_subcategoria' => $validated['nombre_subcategoria'],
                'descripcion_subcategoria' => $validated['descripcion_subcategoria'],
                'id_ctg' => $validated['id_categoria'],
                'imagen_subcategoria' => $nombreImagen,
            ]);
            return redirect()->route('subcategorias')->with('success', 'SubCategoria creado correctamente');
    }
    public function ModificarSubCategoria(Request $request, $id){

        $subcategoria = SubCategoria::findOrFail($id);

        $request->validate([
            'nombre_subcategoria' => 'required|string|max:20',
            'descripcion_subcategoria'=>'required|string|max:255',
            'id_categoria' =>'required|exists:categoria,id_categoria' ,
            'imagen_subcategoria' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $datosModificados =[
            'nombre_subcategoria' => $request->nombre_subcategoria,
            'descripcion_subcategoria' => $request->descripcion_subcategoria,
            'id_ctg' => $request->id_categoria
        ];
        if($request->hasFile('imagen_subcategoria')){
            if($subcategoria->imagen_subcategoria){
                $rutaImagen = public_path('imgSubCategoria/'.$subcategoria->imagen_subcategoria);
                if(file_exists($rutaImagen)){
                    @unlink($rutaImagen);
                }
            }
            $file = $request->file('imagen_subcategoria');
            $nombreImagen = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('imgSubCategoria'), $nombreImagen);
            $datosModificados['imagen_subcategoria'] = $nombreImagen;
        }
        $subcategoria->update($datosModificados);
        return redirect()->back()->with('success', 'SubCategoria actualizado correctamente');
    }
    public function eliminarsubcategoria($idsubCategoria)
    {
        $subcategoria = SubCategoria::findOrFail($idsubCategoria);
        if($idsubCategoria){
            return redirect()->back()->with('error', 'SubCategoria no encontrada.');
       }
       $subcategoria->estatus=0;
       $subcategoria->save();
       return redirect()->back()->with('success', 'SubCategoria desactivada exitosamente.');
       
    }
}
