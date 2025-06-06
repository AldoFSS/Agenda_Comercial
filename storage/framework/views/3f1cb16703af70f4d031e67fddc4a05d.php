
<?php $__env->startSection('contenido'); ?>
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
            <?php $__empty_1 = true; $__currentLoopData = $municipios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $municipio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr id="municipio_<?php echo e($municipio->id_municipio); ?>">
                    <td><?php echo e($municipio->id_municipio); ?></td>
                    <td><?php echo e($municipio->municipio); ?></td>
                    <td data-id="<?php echo e($municipio->id_estd); ?>"><?php echo e($municipio->Estado); ?></td>
                    <td><?php echo e($municipio->created_at); ?></td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles de la Zona" href="#" class="btn btn-primary btn-editar"  data-bs-toggle="modal" data-bs-target="#editarMunicipioModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Zona" class="btn btn-danger btn-eliminar" data-tipo="municipio" data-id="<?php echo e($municipio->id_municipio); ?>">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay Municipios disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="crearMunicipioModal" tabindex="-1" aria-labelledby="crearMunicipioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form form method="POST" action="<?php echo e(route('municipios.crear')); ?>">
            <?php echo csrf_field(); ?>
           
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
                        <?php if(isset($estados)): ?>
                            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado->id_estado); ?>"><?php echo e($estado->nombre_estado); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
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
            <?php echo csrf_field(); ?>
             <?php echo method_field('PUT'); ?>
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
                        <?php if(isset($estados)): ?>
                            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado->id_estado); ?>"><?php echo e($estado->nombre_estado); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_municipio.js']); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/municipios.blade.php ENDPATH**/ ?>