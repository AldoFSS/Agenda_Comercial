@extends('layouts.app')
@section('contenido')
<!-- Modal -->
<div class="table-responsive">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearMarcaModal">Nueva Marca</button>
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Marca</th>
                <th class="centered">Descripcion</th>
                <th class="centered">fecha registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($marcas as $marca)
                <tr id="marca_{{ $marca->id_marca}}">
                    <td>{{ $marca->id_marca }}</td>
                    <td>{{ $marca->nombre_marca }}</td>
                    <td>{{ $marca->descripcion_marca }}</td>
                    <td>{{ $marca->created_at }}</td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles de la Zona" href="#" class="btn btn-primary btn-editarMarca"  data-bs-toggle="modal" data-bs-target="#editarMarcaModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Zona" class="btn btn-danger btn-eliminar" data-tipo="marca" data-id="{{ $marca->id_marca}}">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay Marcas disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<!-- MODAL CREAR-->
<div class="modal fade" id="crearMarcaModal" tabindex="-1" aria-labelledby="crearMarcaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form form method="POST" action="{{ route('marcas.crear') }}">
            @csrf
            <input type="hidden" name="id" id="marcaId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertarMarcaLabel">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre Marca:</label>
                    <input type="text" class="form-control" name="nombre_marca" id="nombreMarca"  required>
                </div>
                 <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion_marca" id="descripcionMarca"  required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary ">Guardar Marca</button>
            </div>
        </div>
    </form>
  </div>
</div>
<!-- MODAL ACTUALIZAR-->
<div class="modal fade" id="editarMarcaModal" tabindex="-1" aria-labelledby="editarMarcaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="formActualizarMarca">
            @csrf
            @method('PUT')
            <input type="hidden" name="editar_id" id="editar_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarProductoLabel">Editar Marca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombre_marca" id="editar_marca" value="{{ $marca->nombre_marca ?? ''  }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion:</label>
                        <input type="text" class="form-control" name="descripcion_marca" id="editar_descripcion" value="{{ $marca->descripcion_marca ?? ''  }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btn-ver-detalle">Actualizar Marca</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@vite(['resources/js/funciones/funciones_marca.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>