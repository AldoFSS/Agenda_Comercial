@extends('layouts.app')
@section('contenido')
<div class="table-responsive">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">Nuevo Usuario</button>
    <div class="table-responsive-sm">
        <table id="miTabla" class="table table-hover">
            <thead>
                <tr>
                    <th class="centered">#</th>
                    <th class="centered">Imagen</th>
                    <th class="centered">nombre</th>
                    <th class="centered">telefono</th>
                    <th class="centered">correo</th>
                    <th class="centered">cargo</th>
                    <th class="centered">Fecha_registro</th>
                    <th class="centered">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                    <tr id="usuario_{{ $usuario->id_usuario }}">
                        <td>{{ $usuario->id_usuario }}</td>
                        <td>
                            @if ($usuario->imagen)
                                <img src="{{ asset('imgUsuario/' . $usuario->imagen) }}" width="50">
                            @else
                                <img src="{{ asset('imgUsuario/user_default.png') }}" width="50">
                            @endif
                        </td>
                        <td>{{ $usuario->nombre_usuario }}</td>
                        <td>{{ $usuario->telefono }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>{{ $usuario->rol }}</td>
                        <td>{{ $usuario->created_at }}</td>
                        <td class=" row justify-content-center">
                            <ul class="opciones">
                                <li>
                                    <a title="Ver detalles del Usuario" href="#" class="btn btn-primary btn-editarUsuario"  data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                        <i class="fas fa-edit" title="Editar"></i>
                                    </a>
                                </li>
                                <li>
                                    
                                    <a title="Eliminar Usuario" href="#" class="btn btn-danger btn-eliminar" data-tipo="usuario" data-id="{{ $usuario->id_usuario }}">
                                        <i class="fas fa-trash-alt" title="Eliminar"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay Usuarios disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL CREAR -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('usuarios.crear') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="usuarioId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearUsuarioLabel">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_usuario" id="nombreUsuario"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" id="telefonoUsuario"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagenUsuario" accept="image/*" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo:</label>
                    <input type="email" class="form-control" name="correo" id="correoUsuario" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">contraseña:</label>
                    <input type="password" class="form-control" name="contraseña" id="contraseña" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rol:</label>
                    <select class="form-select" name="rol" required id="rolUsuario">
                    <option value="Administrador" >Administrador</option>
                    <option value="Asesor_Comercial" >Asesor Comercial</option>
                    <option value="Gerente" >Gerente</option>
                    </select>
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
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="formActualizarUsuario" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="editar_id" id="editar_id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_usuario" id="editar_nombre" value="{{ $usuario->nombre_usuario }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" id="editar_telefono" value="{{ $usuario->telefono }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="editar_imagen" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo:</label>
                    <input type="email" class="form-control" name="correo" id="editar_correo" value="{{ $usuario->correo }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rol:</label>
                    <select class="form-select" name="rol" required id="editar_rol">
                    <option value="Administrador" {{ $usuario->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    <option value="Asesor Comercial" {{ $usuario->rol == 'Asesor Comercial' ? 'selected' : '' }}>Asesor Comercial</option>
                    <option value="Gerente" {{ $usuario->rol == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btn-ver-detalle">Actualizar usuario</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection
@vite(['resources/js/funciones/funciones_usuario.js'])
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>