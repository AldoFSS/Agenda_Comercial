@extends('layouts.app')
@section('contenido')
<div class="table-responsive">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearSubCategoriaModal">Nuevo SubCategoria</button>
    <div class="table-responsive-sm">
        <table id="miTabla" class="table table-hover">
            <thead>
                <tr>
                    <th class="centered">#</th>
                    <th class="centered">Imagen</th>
                    <th class="centered">Subcategoria</th>
                    <th class="centered">Categoria</th>
                    <th class="centered">Descripcion</th>
                    <th class="centered">Fecha Registro</th>
                    <th class="centered">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subcategorias as $subctg)
                    <tr id="subcategoria_{{ $subctg->id_subcategoria }}">
                        <td>{{ $subctg->id_subcategoria }}</td>
                        <td>
                            @if ($subctg->imagen_subcategoria)
                                <img src="{{ asset('imgSubCategoria/' . $subctg->imagen_subcategoria) }}" width="50">
                            @else
                                <img src="{{ asset('imgSubCategoria/img_default.png') }}" width="50">
                            @endif
                        </td>
                        <td>{{ $subctg->nombre_subcategoria }}</td>
                        <td data-id="{{ $subctg->id_ctg }}">{{ $subctg->Categoria ?? 'Sin Categoria'}}</td>
                        <td>{{ $subctg->descripcion_subcategoria }}</td>
                        <td>{{ $subctg->created_at }}</td>
                        <td class=" row justify-content-center">
                            <ul class="opciones">
                                <li>
                                    <a title="Ver detalles del la subcategoria" href="#" class="btn btn-primary btn-editarsubCategoria" data-id="{{ $subctg->id_subcategoria }}" data-bs-toggle="modal" data-bs-target="#editarsubCategoriaModal">
                                        <i class="fas fa-edit" title="Editar"></i>
                                    </a>
                                </li>
                                <li>      
                                    <a title="Eliminar subcategoria" href="#" class="btn btn-danger btn-eliminar" data-tipo="subcategoria" data-id="{{  $subctg->id_subcategoria }}">
                                        <i class="fas fa-trash-alt" title="Eliminar"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                   @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay SubCategorias disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL CREAR -->
<div class="modal fade" id="crearsubCategoriaModal" tabindex="-1" aria-labelledby="crearsubCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('subcategorias.crear') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_subcategoria" id="subCategoriaId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearsubCategoriaLabel">Nuevo Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_subcategoria" id="nombresubCategoria"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion_subcategoria" id="descripcionsubCategoria"  required>
                </div>
                <div class="mb-3">
                    <label for="editar_subCategoria">Categoria</label>
                    <select class="form-control" name="id_categoria" required>
                        <option value="">Seleccione una Categoria</option>
                        @isset($categorias)
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_Categoria}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen_subcategoria" id="imagensubCategoria" accept="image/*"  required >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary ">Guardar usuario</button>
            </div>
        </div>
    </form>
  </div>
</div>
<!-- MODAL EDITAR-->
<div class="modal fade" id="editarsubCategoriaModal" tabindex="-1" aria-labelledby="editarsubCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="formActualizarsubCategoria" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="editar_id" id="editar_id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarsubCategoriaLabel">Editar subCategoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_subcategoria" id="editar_nombre" value="{{ $catg->nombre_Categoria ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion_subcategoria" id="editar_descripcion" value="{{ $catg->descripcion ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="editar_categoria">Categoria</label>
                    <select class="form-control" name="id_categoria" id="editar_categoria" required>
                        <option value="">Seleccione una Categoria</option>
                        @isset($categorias)
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_Categoria}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen_subcategoria" id="editar_imagenCategoria" accept="image/*">
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
@vite(['resources/js/funciones/funciones_subcategorias.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>