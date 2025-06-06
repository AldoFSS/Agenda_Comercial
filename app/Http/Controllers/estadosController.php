<?php

namespace App\Http\Controllers;

use App\Models\estados;
use Illuminate\Http\Request;

class estadosController
{
    public function MostrarEstados(){
        $estados = estados::where('estatus','=', '1')->get();

        return view('paginas.estados', compact('estados'));
    }
}
