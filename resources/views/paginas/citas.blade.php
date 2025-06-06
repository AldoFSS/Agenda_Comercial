@extends('layouts.app')
@section('contenido')
<div class="table-responsive">
<div id="calendario" class="fc fc-media-screen fc-direction-ltr fc-theme-standard" style="margin: 20px;"></div>
<div class="sticky-button" id="zonaEliminar">
  <i class="fas fa-trash"></i>
</div>

<!-- Modal Crear Cita -->
<div class="modal fade" id="crearCitaModal" tabindex="-1" aria-labelledby="crearCitaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('citas.crear') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearCitaModalLabel">Nueva Cita</h5>
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
          <div class="mb-3">
            <label for="hora_inicio">Calendario:</label>
            <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
          </div>

          <div class="mb-3">
            <label for="hora_inicio">Hora Inicio:</label>
            <input type="time" class="form-control" name="hora_inicio">
          </div>

          <div class="mb-3">
            <label for="hora_fin">Hora Fin:</label>
            <input type="time" class="form-control" name="hora_fin">
          </div>

          <div class="mb-3">
            <label for="motivo">Motivo:</label>
            <input type="text" class="form-control" name="motivo" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cita</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal Editar Cita -->
<div class="modal fade" id="editarCitaModal" tabindex="-1" aria-labelledby="editarCitaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <form method="POST" id="formActualizarCita">
  @csrf
  @method('PUT')
  <input type="hidden" name="editar_id" id="editar_id">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editarCitaModalLabel">Editar Cita</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body">
      <div class="mb-3">
        <label for="editar_cliente">Cliente:</label>
        <select class="form-control" name="id_cliente" id="editar_cliente" required>
          <option value="">Selecciona un cliente</option>
          @isset($usuarios)
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
            <label for="hora_inicio">Calendario:</label>
            <input type="date" class="form-control" name="fecha_cita" id="editar_fecha_cita" required>
          </div>
      <div class="mb-3">
        <label for="editar_hora_inicio">Hora Inicio:</label>
        <input type="time" class="form-control" name="hora_inicio" id="editar_hora_inicio" >
      </div>

      <div class="mb-3">
        <label for="editar_hora_fin">Hora Fin:</label>
        <input type="time" class="form-control" name="hora_fin" id="editar_hora_fin">
      </div>

      <div class="mb-3">
        <label for="editar_motivo">Motivo:</label>
        <input type="text" class="form-control" name="motivo" id="editar_motivo" required>
      </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-primary">Actualizar Cita</button>
    </div>
  </div>
</form>

  </div>
</div>
@endsection
@vite(['resources/js/funciones/funciones_citas.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>