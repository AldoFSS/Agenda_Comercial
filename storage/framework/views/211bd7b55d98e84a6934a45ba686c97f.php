
<?php $__env->startSection('contenido'); ?>
<!-- Modal -->
<div class="table-responsive">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearZonaModal">Nueva Zona</button>
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Nombre</th>
                <th class="centered">Descripcion</th>
                <th class="centered">fecha registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr id="zona_<?php echo e($zona->id_zona); ?>">
                    <td><?php echo e($zona->id_zona); ?></td>
                    <td><?php echo e($zona->nombre_zona); ?></td>
                    <td><?php echo e($zona->descripcion_zona); ?></td>
                    <td><?php echo e($zona->created_at); ?></td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles de la Zona" href="#" class="btn btn-primary btn-editarZona"  data-bs-toggle="modal" data-bs-target="#editarZonaModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Zona" class="btn btn-danger btn-eliminar" data-tipo="zona" data-id="<?php echo e($zona->id_zona); ?>">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay Zonas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- MODAL CREAR-->
<div class="modal fade" id="crearZonaModal" tabindex="-1" aria-labelledby="crearZonaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form form method="POST" action="<?php echo e(route('zonas.crear')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" id="marcaId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertarZonaLabel">Nueva Zona</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre Zona:</label>
                    <input type="text" class="form-control" name="nombre_zona" id="nombreZona"  required>
                </div>
                 <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion_zona" id="descripcionZona"  required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary ">Guardar Zona</button>
            </div>
        </div>
    </form>
  </div>
</div>
<!-- MODAL ACTUALIZAR-->
<div class="modal fade" id="editarZonaModal" tabindex="-1" aria-labelledby="editarZonaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="formActualizarZona">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="editar_id" id="editar_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarProductoLabel">Editar Zona</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombre_zona" id="editar_zona" value="<?php echo e($zona->nombre_zona ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion:</label>
                        <input type="text" class="form-control" name="descripcion_zona" id="editar_descripcion" value="<?php echo e($zona->descripcion_zona ?? ''); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btn-ver-detalle">Actualizar Zona</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_zona.js']); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/zonas.blade.php ENDPATH**/ ?>