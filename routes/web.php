<?php
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EliminacionController;
use App\Http\Controllers\estadosController;
use App\Http\Controllers\graficaController;
use App\Http\Controllers\marcasController;
use App\Http\Controllers\municipiosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\SubCategoriasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\zonasController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (){
    Route::get('/usuarios',[UsuariosController::class,'index'])->name('usuarios');
    Route::post('/usuarios/buscar',[UsuariosController::class,'BuscarUsuario'])->name('buscar');
    Route::put('/usuarios/actualizar/{id}', [UsuariosController::class, 'updateUsuario'])->name('usuarios.actualizar');
    Route::post('/usuarios/insertar', [UsuariosController::class, 'crearUsuario'])->name('usuarios.crear');
    Route::post('/usuarios/eliminar/{id}', [UsuariosController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
    Route::get('/productos',[ProductosController::class,'MostrarProductos'])->name('productos');
    Route::put('/productos/actualizar/{id}', [ProductosController::class,'actualizarProducto'])->name('productos.actualizar');
    Route::post('/productos/insertar', [ProductosController::class,'crearProducto'])->name('productos.crear');
    Route::get('/clientes',[ClientesController::class,'mostrarClientes'])->name('clientes');
    Route::put('/clientes/actualizar/{id}', [ClientesController::class, 'actualizarCliente'])->name('cliente.actualizar');
    Route::post('/clientes/insertar', [ClientesController::class, 'crearCliente'])->name('cliente.crear');
    Route::get('/clientes/buscarMunicipio/{id}', [ClientesController::class, 'BuscarMunicipio'])->name('cliente.buscar');
    Route::get('/citas',[CitasController::class,'mostrarCitas'])->name('citas');
    Route::put('/citas/actualizar/{id}', [CitasController::class, 'actualizarCita'])->name('citas.actualizar');
    Route::put('/citas/actualizarfecha/{id}',[CitasController::class, 'actualizarFecha'])->name('citas.actfecha');
    Route::post('/citas/eliminar/{id}', [CitasController::class, 'eliminarCita'])->name('citas.eliminar');
    Route::post('/citas/insertar', [CitasController::class, 'crearCita'])->name('citas.crear');
    Route::get('/obtenerEvento',[CitasController::class,'obtenerEventos'])->name('citas.obtenerEventos');
    Route::get('/ventas',[VentasController::class,'mostrarventas'])->name('ventas');
    Route::put('/ventas/actualizar/{id}', [VentasController::class, 'actualizarVenta'])->name('ventas.actualizar');
    Route::post('/ventas/insertar', [VentasController::class, 'crearVenta'])->name('ventas.crear');
    Route::get('/ventas/detalles/{id}', [VentasController::class, 'obtenerDetalles']);
    Route::get('/categoria',[CategoriasController::class,'MostrarCatalogo'])->name('categorias');
    Route::post('/categoria/insertar', [CategoriasController::class,'CrearCategoria'])->name('categorias.crear');
    Route::put('/categoria/actualizar/{id}', [CategoriasController::class,'ModificarCategoria'])->name('categorias.actualizar');
    Route::get('/subcategoria',[SubCategoriasController::class,'MostrarSubCategorias'])->name('subcategorias');
    Route::post('/subcategoria/insertar', [SubCategoriasController::class,'CrearSubCategoria'])->name('subcategorias.crear');
    Route::put('/subcategoria/actualizar/{id}', [SubCategoriasController::class,'ModificarSubCategoria'])->name('subcategorias.actualizar');
    Route::get('/zonas',[zonasController::class, 'MostrarZonas'])->name('zonas');
    Route::post('/zonas/insertar', [zonasController::class,'CrearZona'])->name('zonas.crear');
    Route::put('zonas/actualizar/{id}', [zonasController::class,'modificarZona'])->name('zonas.actualizar');
    Route::get('/marcas',[marcasController::class, 'MostrarMarcas'])->name('marcas');
    Route::post('/marcas/insertar', [marcasController::class,'CrearMarca'])->name('marcas.crear');
    Route::put('marcas/actualizar/{id}', [marcasController::class,'modificarMarca'])->name('marcas.actualizar');
    Route::get('/estados',[estadosController::class, 'MostrarEstados'])->name('estados');
    Route::get('/municipios',[municipiosController::class, 'MostrarMunicipios'])->name('municipios');
    Route::post('/municipios/insertar', [municipiosController::class,'CrearMunicipio'])->name('municipios.crear');
    Route::put('municipios/actualizar/{id}', [municipiosController::class,'EditarMunicipio'])->name('municipios.actualizar');
    Route::get('/productos/lista',[VentasController::class,'obtenerProductos'])->name('ventas.productos');
    Route::get('/reporte/mostrar/{tipoGrafica},{fecha_inicio},{fecha_final},{id}', [graficaController::class, 'reporteGrafica'])->name('reporte.mostrar');
    Route::get('/grafico/mostrar/{tipoGrafica},{fecha_inicio},{fecha_final}', [graficaController::class, 'mostrarGrafica'])->name('grafico.mostrar');
    Route::get('//reporte/opciones/{tipo}',[graficaController::class,'mostrarOpciones'])->name('reporte.tipo');
    Route::post('/eliminar/{tipo}/{id}',[EliminacionController::class,'eliminar']);

    Route::get('/', function () {
        return view('paginas.login');

    })->name('login');
    Route::get('/home', function () {
        return view('paginas.home');

    })->name('home');

    Route::get('/grafico', function () {
        return view('paginas.grafico');
    })->name('grafico');
    Route::get('/reporte', function () {
        return view('paginas.reportes');
    })->name('reportes');
});
