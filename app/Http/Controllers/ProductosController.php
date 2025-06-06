<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\cliente;
use App\Models\marcas;
use App\Models\productos;
use App\Models\SubCategoria;
use Illuminate\Http\Request;

class ProductosController 
{
    public function MostrarProductos()
    {
        $productos = productos::select([
            'productos.*',
            'categoria.nombre_Categoria as Categoria',
            'subcategoria.nombre_subcategoria as Subcategoria',
            'marcas.nombre_marca as Marca',
            'cliente.nombre_comercial as proveedor',
            'cliente.id_cliente'
        ])
        ->join('categoria','productos.id_catg', '=','categoria.id_categoria')
        ->join('subcategoria','productos.id_subcatg', '=','subcategoria.id_subcategoria')
        ->join('marcas','productos.id_marc', '=','marcas.id_marca')
        ->join('cliente','productos.id_proveedor', '=','cliente.id_cliente')
        ->where('productos.estatus',1)
        ->get();

        $categorias = Categoria::where('estatus',1)->get();
        $subcategorias = SubCategoria::where('estatus',1)->get();
        $proveedores = cliente::where([
            ['estatus', '=', 1],
            ['rol', '=', 'proveedor'],
        ])->select('id_cliente', 'nombre_comercial')->get();

        $marcas = marcas::where('estatus',1)->get();

        return view('paginas.productos', compact('productos','categorias','marcas','subcategorias','proveedores'));
    }
    public function crearProducto(Request $request){
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'stock' => 'required|integer|max:999',
            'precio_unitario' => 'required|numeric|max:99999999.99',
            'precio_venta' => 'required|numeric|max:99999999.99',
            'IVA_producto' => 'required|numeric|max:99999999.99',
            'id_categoria'=>'required|exists:categoria,id_categoria',
            'id_subcategoria'=>'required|exists:subcategoria,id_subcategoria',
            'id_proveedor'=>'required|exists:cliente,id_cliente',
            'id_marca'=>'required|exists:marcas,id_marca',
            'imagen_producto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'codigo' => 'required|string|max:255'
        ]);

        $nombreImagen = null;
        if($request->hasFile('imagen_producto'))
        {
            $file = $request->file('imagen_producto');
            $nombreImagen = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('imgProductos'),$nombreImagen);
        }
        $producto = productos::create([
            'nombre_producto' => $request->nombre_producto,
            'stock' => $request->stock,
            'precio_unitario' => $request->precio_unitario,
            'precio_venta' => $request->precio_venta,
            'IVA_producto'=> $request->IVA_producto,
            'id_catg'=> $request->id_categoria,
            'id_subcatg'=>$request->id_subcategoria,
            'id_proveedor'=>$request->id_proveedor,
            'id_marc'=>$request->id_marca,
            'imagen_producto'=>$nombreImagen,
            'codigo' => $request->codigo
        ]);
        return redirect()->route('productos')->with('success','Producto creado correctamente');
    }
    public function actualizarProducto(Request $request, $id)
    {
        $Producto = productos::findOrFail($id);
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'stock' => 'required|integer|max:999',
            'precio_unitario' => 'required|numeric|max:99999999.99',
            'precio_venta' => 'required|numeric|max:99999999.99',
            'IVA_producto' => 'required|numeric|max:99999999.99',
            'id_categoria'=>'required|exists:categoria,id_categoria',
            'id_subcategoria'=>'required|exists:subcategoria,id_subcategoria',
            'id_marca'=>'required|exists:marcas,id_marca',
            'id_proveedor'=>'required|exists:cliente,id_cliente',
            'imagen_producto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'codigo' => 'required|string|max:255'
        ]);
        $datosModificados= [
            'nombre_producto' => $request->nombre_producto,
            'stock' => $request->stock,
            'precio_unitario' => $request->precio_unitario,
            'precio_venta' => $request->precio_venta,
            'IVA_producto'=> $request->IVA_producto,
            'id_catg'=> $request->id_categoria,
            'id_subcatg'=>$request->id_subcategoria,
            'id_marc'=>$request->id_marca,
            'codigo'=> $request->codigo,
            'id_proveedor'=> $request->id_proveedor
        ];
        if($request->hasFile('imagen_producto')){
            if($Producto->imagen_producto){
                $rutaImagen = public_path('imgProductos/'.$Producto->imagen_producto);
                if(file_exists($rutaImagen)){
                    @unlink($rutaImagen);
                }
            }
            $file = $request->file('imagen_producto');
            $nombreImagen = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('imgProductos'), $nombreImagen);
            $datosModificados['imagen_producto'] = $nombreImagen;
        }
        
        $Producto->update($datosModificados);
        return redirect()->back()->with('success', 'Producto actualizado correctamente');
    }
    public function eliminarProducto($idProducto){
        $producto = productos::find($idProducto);

        if(!$idProducto){
         return redirect()->back()->with('error', 'Producto no encontrado.');
        }
 
        $producto->estatus=0;
        $producto->save();
        return redirect()->back()->with('success', 'Producto eliminado exitosamente.');
    }
}
