<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\cliente;
use App\Models\estados;
use App\Models\marcas;
use App\Models\municipios;
use App\Models\productos;
use App\Models\SubCategoria;
use App\Models\usuarios;
use App\Models\ventas;
use App\Models\zonas;
use Illuminate\Http\Request;

class EliminacionController 
{
    public function eliminar($tipo, $id)
    {
        switch($tipo) {
            case 'usuario':
                $obj = usuarios::find($id);
                break;
            case 'venta':
                $obj = ventas::find($id);
                break;
            case 'cliente':
                $obj = cliente::find($id);
                break;
            case 'producto':
                $obj = productos::find($id);
                break;
            case 'categoria':
                $obj = Categoria::find($id);
                break;
            case 'subcategoria':
                $obj = SubCategoria::find($id);
                break;
            case 'marca':
                $obj = marcas::find($id);
                break;
            case 'zona':
                $obj = zonas::find($id);
                break;
            case 'municipio':
                $obj = municipios::find($id);
                break;
            case 'estado':
                $obj = estados::find($id);
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Tipo no válido.']);
        }

        if (!$obj) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado.']);
        }
        $obj->estatus = 0;
        $obj->save();

        return response()->json(['success' => true, 'message' => ucfirst($tipo) . ' eliminado correctamente.']);
    }
}
