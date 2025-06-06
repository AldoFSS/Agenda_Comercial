@extends('layouts.app')
@section('contenido')
<div class="table-responsive">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">Nuevo Categoria</button>
    <div class="table-responsive-sm">
        <table id="miTabla" class="table table-hover">
            <thead>
                <tr>
                    <th class="centered">#</th>
                    <th class="centered">Imagen</th>
                    <th class="centered">nombre</th>
                    <th class="centered">Descripcion</th>
                    <th class="centered">Fecha Registro</th>
                    <th class="centered">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $catg)
                    <tr id="categoria_{{ $catg->id_categoria }}">
                        <td>{{ $catg->id_categoria }}</td>
                        <td>
                            @if ($catg->imagen_Categoria)
                                <img src="{{ asset('imgCategoria/' . $catg->imagen_Categoria) }}" width="50">
                            @else
                               <img src="{{ asset('imgCategoria/img_default.png') }}" width="50">
                            @endif
                        </td>
                        <td>{{ $catg->nombre_Categoria }}</td>
                        <td>{{ $catg->descripcion }}</td>
                        <td>{{ $catg->created_at }}</td>
                        <td class=" row justify-content-center">
                            <ul class="opciones">
                                <li>
                                    <a title="Ver detalles del la categoria" href="#" class="btn btn-primary btn-editarCategoria"  data-bs-toggle="modal" data-bs-target="#editarCategoriaModal">
                                        <i class="fas fa-edit" title="Editar"></i>
                                    </a>
                                </li>
                                <li>      
                                    <a title="Eliminar Categoria" href="#" class="btn btn-danger btn-eliminar" data-tipo="categoria" data-id="{{  $catg->id_categoria }}">
                                        <i class="fas fa-trash-alt" title="Eliminar"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                   @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay Categorias disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL CREAR -->
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form form method="POST" action="{{ route('categorias.crear') }}"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="CategoriaId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearCategoriaLabel">Nueva Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_Categoria" id="nombreCategoria"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcionCategoria"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen_Categoria" id="imagenCategoria" accept="image/*"  required >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary ">Guardar categoria</button>
            </div>
        </div>
    </form>
  </div>
</div>
<!-- MODAL EDITAR-->
<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="formActualizarCategoria" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="editar_id" id="editar_id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaLabel">Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_Categoria" id="editar_nombre" value="{{ $catg->nombre_Categoria ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion_categoria" id="editar_descripcion" value="{{ $catg->descripcion ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen_Categoria" id="editar_imagenCategoria" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btn-ver-detalle">Actualizar Categoria</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection
@vite(['resources/js/funciones/funciones_categoria.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>