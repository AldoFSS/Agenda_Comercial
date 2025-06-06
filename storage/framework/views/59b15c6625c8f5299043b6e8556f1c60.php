
<?php $__env->startSection('contenido'); ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr id="usuario_<?php echo e($usuario->id_usuario); ?>">
                        <td><?php echo e($usuario->id_usuario); ?></td>
                        <td>
                            <?php if($usuario->imagen): ?>
                                <img src="<?php echo e(asset('imgUsuario/' . $usuario->imagen)); ?>" width="50">
                            <?php else: ?>
                                <img src="<?php echo e(asset('imgUsuario/user_default.png')); ?>" width="50">
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($usuario->nombre_usuario); ?></td>
                        <td><?php echo e($usuario->telefono); ?></td>
                        <td><?php echo e($usuario->correo); ?></td>
                        <td><?php echo e($usuario->rol); ?></td>
                        <td><?php echo e($usuario->created_at); ?></td>
                        <td class=" row justify-content-center">
                            <ul class="opciones">
                                <li>
                                    <a title="Ver detalles del Usuario" href="#" class="btn btn-primary btn-editarUsuario"  data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                        <i class="fas fa-edit" title="Editar"></i>
                                    </a>
                                </li>
                                <li>
                                    
                                    <a title="Eliminar Usuario" href="#" class="btn btn-danger btn-eliminar" data-tipo="usuario" data-id="<?php echo e($usuario->id_usuario); ?>">
                                        <i class="fas fa-trash-alt" title="Eliminar"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay Usuarios disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL CREAR -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('usuarios.crear')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
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
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="editar_id" id="editar_id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_usuario" id="editar_nombre" value="<?php echo e($usuario->nombre_usuario); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" id="editar_telefono" value="<?php echo e($usuario->telefono); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="editar_imagen" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo:</label>
                    <input type="email" class="form-control" name="correo" id="editar_correo" value="<?php echo e($usuario->correo); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rol:</label>
                    <select class="form-select" name="rol" required id="editar_rol">
                    <option value="Administrador" <?php echo e($usuario->rol == 'Administrador' ? 'selected' : ''); ?>>Administrador</option>
                    <option value="Asesor Comercial" <?php echo e($usuario->rol == 'Asesor Comercial' ? 'selected' : ''); ?>>Asesor Comercial</option>
                    <option value="Gerente" <?php echo e($usuario->rol == 'Gerente' ? 'selected' : ''); ?>>Gerente</option>
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
<?php $__env->stopSection(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_usuario.js']); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/usuarios.blade.php ENDPATH**/ ?>