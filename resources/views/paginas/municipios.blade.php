@extends('layouts.app')
@section('contenido')
<!-- Modal -->
<div class="table-responsive">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearMunicipioModal">Nuevo Municipio</button>
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Municipio</th>
                <th class="centered">Estado</th>
                <th class="centered">fecha registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($municipios as $municipio)
                <tr id="municipio_{{ $municipio->id_municipio }}">
                    <td>{{ $municipio->id_municipio }}</td>
                    <td>{{ $municipio->municipio }}</td>
                    <td data-id="{{ $municipio->id_estd }}">{{ $municipio->Estado }}</td>
                    <td>{{ $municipio->created_at }}</td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles de la Zona" href="#" class="btn btn-primary btn-editar"  data-bs-toggle="modal" data-bs-target="#editarMunicipioModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Zona" class="btn btn-danger btn-eliminar" data-tipo="municipio" data-id="{{ $municipio->id_municipio}}">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay Municipios disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="modal fade" id="crearMunicipioModal" tabindex="-1" aria-labelledby="crearMunicipioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form form method="POST" action="{{ route('municipios.crear') }}">
            @csrf
           
            <input type="hidden" name="id" id="municipioId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertarMunicipioLabel">Nuevo Municipio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Municipio:</label>
                    <input type="text" class="form-control" name="nombre_municipio" id="nombreMunicipio"  required>
                </div>
                <div class="mb-3">
                    <label for="editar_usuario">Estado:</label>
                    <select class="form-control" name="id_estado" required>
                        <option value="">Selecciona una Estado</option>
                        @isset($estados)
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado}}">{{ $estado->nombre_estado}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary ">Guardar cliente</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div class="modal fade" id="editarMunicipioModal" tabindex="-1" aria-labelledby="editarMunicipioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form form method="post" id="formActualizarMunicipio">
            @csrf
             @method('PUT')
            <input type="hidden" name="id" id="editar_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertarMunicipioLabel">Editar Municipio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Municipio:</label>
                    <input type="text" class="form-control" name="municipio" id="editar_municipio"  required>
                </div>
                <div class="mb-3">
                    <label for="editar_usuario">Estado:</label>
                    <select class="form-control" name="id_estado" id="editar_estado" required>
                        <option value="">Selecciona una Estado</option>
                        @isset($estados)
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado}}">{{ $estado->nombre_estado}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary ">Guardar cliente</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection
@vite(['resources/js/funciones/funciones_municipio.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>