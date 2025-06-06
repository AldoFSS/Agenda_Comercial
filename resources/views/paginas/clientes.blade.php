@extends('layouts.app')
@section('contenido')
<div class="table-responsive">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearClienteModal">Nuevo Cliente</button>
<div class="table-responsive-sm">
    <table id="miTabla" class="table table-responsive table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Imagen</th>
                <th class="centered">Nombre</th>
                <th class="centered">Nombre_comercial</th>
                <th class="centered">rol</th>
                <th class="centered">telefono</th>
                <th class="centered">correo</th>
                <th class="centered">codigo postal</th>
                <th class="centered">Colonia</th>
                <th class="centered">Calle</th>
                <th class="centered">Estado</th>
                <th class="centered">Municipio</th>
                <th class="centered">Fecha_registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $cliente)
                <tr id="cliente_{{ $cliente->id_cliente }}">
                    <td>{{ $cliente->id_cliente }}</td>
                    <td>
                        @if ($cliente->imagen)
                            <img src="{{ asset('imgCliente/' . $cliente->imagen) }}" width="50">
                        @else
                            <img src="{{ asset('imgCliente/user_default.png') }}" width="50">
                        @endif
                    </td>
                    <td>{{ $cliente->nombre_cliente }}</td>
                    <td>{{ $cliente->nombre_comercial }}</td>
                    <td>{{ $cliente->rol}}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->correo}}</td>
                    <td>{{ $cliente->codigo_postal }}</td>
                    <td>{{ $cliente->colonia}}</td>
                    <td>{{ $cliente->calle}}</td>
                    <td data-id="{{ $cliente->id_estado }}">{{ $cliente->Estado }}</td>
                    <td data-id="{{ $cliente->id_municipio }}">{{ $cliente->Municipio }}</td>
                    <td>{{ $cliente->created_at}}</td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles del Cliente" href="#" class="btn btn-primary btn-editarCliente"  data-bs-toggle="modal" data-bs-target="#editarClienteModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Cliente" href="#" class="btn btn-danger btn-eliminar" data-tipo="cliente" data-id="{{ $cliente->id_cliente }}">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay Clientes disponibles.</td>
                </tr>
            @endforelse
            
        </tbody>
    </table>
</div>
</div>
<!-- MODAL CREAR-->
<div class="modal fade" id="crearClienteModal" tabindex="-1" aria-labelledby="crearClienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('cliente.crear') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="clienteId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="insertarUsuarioLabel">Nuevo Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre_cliente" id="nombreCliente" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nombre Comercial:</label>
                <input type="text" class="form-control" name="nombre_comercial" id="nombreComercialCliente" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" id="telefonoCliente" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Correo:</label>
                <input type="email" class="form-control" name="correo" id="correoCliente" required>
              </div>
              <div class="col-md-12">
                <label class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagenCliente" accept="image/*" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Código Postal:</label>
                <input type="number" class="form-control" name="codigo_postal" id="codigoPostalCliente" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Colonia:</label>
                <input type="text" class="form-control" name="colonia" id="coloniaCliente" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Calle:</label>
                <input type="text" class="form-control" name="calle" id="calleCliente" required>
              </div>
              <div class="col-md-6">
                <label for="Select_estado" class="form-label">Estado</label>
                <select class="form-select" name="id_estado" id="Select_estado" required>
                  <option value="">Seleccione un Estado</option>
                  @isset($estados)
                    @foreach($estados as $estado)
                      <option value="{{ $estado->id_estado }}">{{ $estado->nombre_estado }}</option>
                    @endforeach
                  @endisset
                </select>
              </div>
              <div class="col-md-6">
                <label for="Select_municipio" class="form-label">Municipio</label>
                <select class="form-select" name="id_municipio" id="Select_municipio" required>
                  <option value="">Seleccione un Municipio</option>
                </select>
              </div>
              <div class="col-md-12">
                <label class="form-label">Rol:</label>
                <select class="form-select" name="rol" id="rolCliente" required>
                  <option value="Cliente">Cliente</option>
                  <option value="Prospecto">Prospecto</option>
                  <option value="Proveedor">Proveedor</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex flex-column flex-sm-row gap-2">
          <button type="button" class="btn btn-secondary w-100 w-sm-auto" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary w-100 w-sm-auto">Guardar cliente</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDITAR-->
<div class="modal fade" id="editarClienteModal" tabindex="-1" aria-labelledby="editarClienteLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <form method="post" id="formActualizarCliente" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="editar_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarProductoLabel">Editar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre_cliente" id="editar_nombre"  required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Nombre Comercial:</label>
                <input type="text" class="form-control" name="nombre_comercial" id="editar_nombre_comercial" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" id="editar_telefono" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="editar_imagen" accept="image/*">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Correo:</label>
                <input type="email" class="form-control" name="correo" id="editar_correo" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Código Postal:</label>
                <input type="number" class="form-control" name="codigo_postal" id="editar_codigo_postal" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Colonia:</label>
                <input type="text" class="form-control" name="colonia" id="editar_colonia" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Calle:</label>
                <input type="text" class="form-control" name="calle" id="editar_calle" required>
              </div>
              <div class="col-12 col-md-6">
                <label for="editar_estado" class="form-label">Estado</label>
                <select class="form-select" name="id_estado" id="editar_estado" required>
                  <option value="">Seleccione un Estado</option>
                  @isset($estados)
                    @foreach($estados as $estado)
                      <option value="{{ $estado->id_estado }}">{{ $estado->nombre_estado}}</option>
                    @endforeach
                  @endisset
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label for="editar_municipio" class="form-label">Municipio</label>
                <select class="form-select" name="id_municipio" id="editar_municipio" required>
                  <option value="">Seleccione un Municipio</option>
                </select>
              </div>
              <div class="col-md-12">
                <label class="form-label">Rol:</label>
                <select class="form-select" name="rol" id="editar_rol" required>
                  <option value="Cliente" {{ $cliente->rol == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                  <option value="Prospecto" {{ $cliente->rol == 'Prospecto' ? 'selected' : '' }}>Prospecto</option>
                  <option value="Proveedor" {{ $cliente->rol == 'Proveedor' ? 'selected' : '' }}>Proveedor</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-ver-detalle">Actualizar cliente</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
@vite(['resources/js/funciones/funciones_clientes.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>