@extends('layouts.app')
@section('contenido')
<div class="table-responsive">
<button type="button" class="btn btn-primary btn-crear" data-bs-toggle="modal" data-bs-target="#crearVentaModal">Nueva Venta</button>
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Cliente</th>
                <th class="centered">Usuario</th>
                <th class="centered">fecha venta</th>
                <th class="centered">fecha registro</th>
                <th class="centered">total</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ventas as $venta)
                <tr id="venta_{{ $venta->id_venta}}">
                    <td>{{ $venta->id_venta}}</td>
                    <td data-id="{{ $venta->id_cli }}">{{ $venta->Cliente ?? 'Sin cliente' }}</td>
                    <td data-id="{{ $venta->id_usr }}">{{ $venta->Usuario ?? 'Sin usuario' }}</td>
                    <td>{{ $venta->fecha_venta }}</td>
                    <td>{{ $venta->created_at }}</td>
                    <td>{{ $venta->total }}</td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles del la venta" href="#" class="btn btn-primary btn-editar" data-id="{{ $venta->id_venta }}" data-bs-toggle="modal" data-bs-target="#editarVentaModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Venta" href="#" class="btn btn-danger btn-eliminar" data-tipo="venta" data-id="{{ $venta->id_venta }}">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay ventas disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Crear Venta-->
<div class="modal fade" id="crearVentaModal" tabindex="-1" aria-labelledby="crearVentaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('ventas.crear') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearCitaModalLabel">Nueva Venta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="cliente">Cliente:</label>
            <select class="form-control" name="id_cliente" required>
              <option value="">Selecciona un cliente</option>
              @isset($clientes)
                @foreach($clientes as $cliente)
                  <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre_cliente }}</option>
                @endforeach
              @endisset
            </select>
          </div>
          <div class="mb-3">
            <label for="usuario">Usuario:</label>
            <select class="form-control" name="id_usuario" required>
              <option value="">Selecciona un usuario</option>
              @isset($usuarios)
                @foreach($usuarios as $usuario)
                  <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre_usuario }}</option>
                @endforeach
              @endisset
            </select>
          </div>
          <table id="productosTable">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody>
          <tr>
            </tr>
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-agregar-fila >Agregar producto</button>
          <div class="mb-3">
            <label for="fecha_venta">Fecha Venta:</label>
            <input type="date" class="form-control" name="fecha_venta" required>
          </div>
          <div class="mb-3">
            <label>Total</label>
            <input type="number" class="form-control" name="total" step="0.01" id="total" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar venta</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!--Modal editarVenta-->
<div class="modal fade" id="editarVentaModal" tabindex="-1" aria-labelledby="editarVentaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <form method="POST" id="formActualizarVenta">
  @csrf
  @method('PUT')
  <input type="hidden" name="editar_id" id="editar_id">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editarVentaModalLabel">Editar Venta</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body">
      <div class="mb-3">
        <label for="editar_cliente">Cliente:</label>
        <select class="form-control" name="id_cliente" id="editar_cliente" required>
          <option value="">Selecciona un cliente</option>
          @isset($clientes)
            @foreach($clientes as $cliente)
              <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre_cliente }}</option>
            @endforeach
          @endisset
        </select>
      </div>
      <div class="mb-3">
        <label for="editar_usuario">Usuario:</label>
        <select class="form-control" name="id_usuario" id="editar_usuario" required>
          <option value="">Selecciona un usuario</option>
          @isset($usuarios)
            @foreach($usuarios as $usuario)
              <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre_usuario }}</option>
            @endforeach
          @endisset
        </select>
      </div>
      <div class="mb-3">
        <label for="editar_fecha_venta">Fecha_venta:</label>
        <input type="date" class="form-control" name="fecha_venta" id="editar_fecha_venta" value="{{ $venta->fecha_venta ?? '' }}" >
      </div>
      <table class="table" id="tablaDetalles">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
              <th>IVA</th>
              <th>Total</th>
              <th>Quitar</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-agregar-filaDetalles>Agregar producto</button>
      <div class="mb-3">
        <label>Total</label>
        <input type="number" class="form-control" name="total" step="0.01" id="editar_total" readonly>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-primary">Actualizar Venta</button>
    </div>
  </div>
</form>
  </div>
</div>

@endsection
@vite(['resources/js/funciones/funciones_ventas.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>