@extends('layouts.app')
@section('contenido')
<!-- Modal -->
<div class="table-responsive">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">Nuevo Producto</button>
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Imagen</th>
                <th class="centered">Producto</th>
                <th class="centered">Categoria</th>
                <th class="centered">SubCategoria</th>
                <th class="centered">Marca</th>
                <th class="centered">Cantidad</th>
                <th class="centered">precio_unitario</th>
                <th class="centered">precio_venta</th>
                <th class="centered">IVA</th>
                <th class="centered">Codigo</th>
                <th class="centered">Proveedor</th>
                <th class="centered">Fecha_registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr id="producto_{{ $producto->id_producto }}">
                    <td>{{ $producto->id_producto }}</td>
                    <td>
                        @if ($producto->imagen_producto)
                            <img src="{{ asset('imgProductos/' . $producto->imagen_producto) }}" width="50">
                        @else
                            <img src="{{ asset('imgProductos/img_default.png') }}" width="50">
                        @endif
                    </td>
                    <td>{{ $producto->nombre_producto }}</td>
                    <td data-id="{{ $producto->id_catg }}">{{ $producto->Categoria }}</td>
                    <td data-id="{{ $producto->id_subcatg }}">{{ $producto->Subcategoria }}</td>
                    <td data-id="{{ $producto->id_marc }}">{{ $producto->Marca }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->precio_unitario }}</td>
                    <td>{{ $producto->precio_venta }}</td>
                    <td>{{ $producto->IVA_producto }}</td>
                    
                    <td>{{ $producto->codigo }}</td>
                    <td data-id="{{ $producto-> id_proveedor }}">{{ $producto->proveedor }}</td>
                    <td>{{ $producto->created_at}}</td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles del Producto" href="#" class="btn btn-primary btn-editar"  data-bs-toggle="modal" data-bs-target="#editarProductoModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Producto" class="btn btn-danger btn-eliminar" data-tipo="producto" data-id="{{ $producto->id_producto }}">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay Productos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<!-- MODAL CREAR-->
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('productos.crear') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="productoId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="insertarProductoLabel">Nuevo Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="form-label">Nombre:</label>
              <input type="text" class="form-control" name="nombre_producto" id="nombreProducto" required>
            </div>

            <div class="col-12 col-md-6">
              <label for="editar_usuario">Proveedor:</label>
              <select class="form-control" name="id_proveedor" required>
                <option value="">Selecciona un proveedor</option>
                @isset($proveedores)
                  @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_cliente }}">{{ $proveedor->nombre_comercial }}</option>
                  @endforeach
                @endisset
              </select>
            </div>

            <div class="col-12 col-md-4">
              <label for="editar_usuario">Categoria:</label>
              <select class="form-control" name="id_categoria" required>
                <option value="">Selecciona una Categoria</option>
                @isset($categorias)
                  @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_Categoria }}</option>
                  @endforeach
                @endisset
              </select>
            </div>

            <div class="col-12 col-md-4">
              <label for="editar_usuario">Subcategoria:</label>
              <select class="form-control" name="id_subcategoria" required>
                <option value="">Selecciona una subcategoria</option>
                @isset($subcategorias)
                  @foreach($subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id_subcategoria }}">{{ $subcategoria->nombre_subcategoria }}</option>
                  @endforeach
                @endisset
              </select>
            </div>

            <div class="col-12 col-md-4">
              <label for="editar_usuario">Marca:</label>
              <select class="form-control" name="id_marca" required>
                <option value="">Selecciona una Marca</option>
                @isset($marcas)
                  @foreach($marcas as $marca)
                    <option value="{{ $marca->id_marca }}">{{ $marca->nombre_marca }}</option>
                  @endforeach
                @endisset
              </select>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Imagen:</label>
              <input type="file" class="form-control" name="imagen_producto" id="imagenProducto" accept="image/*" required>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Stock:</label>
              <input type="number" class="form-control" name="stock" id="stockProducto" required>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Código de barras:</label>
              <input type="text" class="form-control" name="codigo" id="codigoProducto" required>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center"  
            style="background-color: #f8f9fa; border: 1px solid #ddd; height: 60px; min-height: 80px; position: relative;">
              <svg id="barcode"></svg>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">Precio:</label>
              <input type="number" class="form-control" name="precio_unitario" id="precioUnitarioProducto" step="0.01" required>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">Precio Venta:</label>
              <input type="number" class="form-control" name="precio_venta" id="precioVentaProducto" step="0.01" required>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">IVA:</label>
              <input type="number" class="form-control" name="IVA_producto" id="IVAProducto" step="0.01" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDITAR-->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoLabel" aria-hidden="true"> 
  <div class="modal-dialog modal-dialog-centered modal-lg"> 
    <form method="post" id="formActualizarProducto" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="editar_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarProductoLabel">Editar Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row g-3"> 
              <div class="col-12 col-md-6">
                <label class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre_producto" id="editar_nombre" required>
              </div>
              <div class="col-12 col-md-6">
                <label>Proveedor:</label>
                <select class="form-select" name="id_proveedor" id="editar_proveedor" required>
                  <option value="">Selecciona un proveedor</option>
                  @isset($proveedores)
                    @foreach($proveedores as $proveedor)
                      <option value="{{ $proveedor->id_cliente }}">{{ $proveedor->nombre_comercial }}</option>
                    @endforeach
                  @endisset
                </select>
              </div>
              <div class="col-12 col-md-4">
                <label>Categoria:</label>
                <select class="form-select" name="id_categoria" id="editar_categoria" required>
                  <option value="">Selecciona una Categoria</option>
                  @isset($categorias)
                    @foreach($categorias as $categoria)
                      <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_Categoria }}</option>
                    @endforeach
                  @endisset
                </select>
              </div>
              <div class="col-12 col-md-4">
                <label>SubCategoria:</label>
                <select class="form-select" name="id_subcategoria" id="editar_subcategoria" required>
                  <option value="">Selecciona una subcategoria</option>
                  @isset($subcategorias)
                    @foreach($subcategorias as $subcategoria)
                      <option value="{{ $subcategoria->id_subcategoria }}">{{ $subcategoria->nombre_subcategoria }}</option>
                    @endforeach
                  @endisset
                </select>
              </div>
              <div class="col-12 col-md-4">
                <label>Marca:</label>
                <select class="form-select" name="id_marca" id="editar_marca" required>
                  <option value="">Selecciona una Marca</option>
                  @isset($marcas)
                    @foreach($marcas as $marca)
                      <option value="{{ $marca->id_marca }}">{{ $marca->nombre_marca }}</option>
                    @endforeach
                  @endisset
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen_producto" id="editar_imagenProducto" accept="image/*">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Stock:</label>
                <input type="number" class="form-control" name="stock" id="editar_stock" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Codigo de barras:</label>
                <input type="text" class="form-control" name="codigo" id="editar_codigo" required>
              </div>
              <div class="col-12 col-md-6 d-flex justify-content-center align-items-center"
               style="background-color: #f8f9fa; border: 1px solid #ddd; min-height: 80px; position: relative;">
                <svg id="barcode_editar"></svg>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label">Precio:</label>
                <input type="number" class="form-control" name="precio_unitario" id="editar_precio_unitario" step="0.01" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label">Precio Venta:</label>
                <input type="number" class="form-control" name="precio_venta" id="editar_precio_venta" step="0.01" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label">IVA:</label>
                <input type="number" class="form-control" name="IVA_producto" id="editar_IVA_producto" step="0.01" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
@vite(['resources/js/funciones/funciones_productos.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>