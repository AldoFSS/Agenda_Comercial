
<?php $__env->startSection('contenido'); ?>
<!-- Modal -->
<div class="table-responsive">
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Estado</th>
                <th class="centered">fecha registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr id="estado_<?php echo e($estado->id_estado); ?>">
                    <td><?php echo e($estado->id_estado); ?></td>
                    <td><?php echo e($estado->nombre_estado); ?></td>
                    <td><?php echo e($estado->created_at); ?></td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Eliminar Zona" class="btn btn-danger btn-eliminar" data-tipo="estado" data-id="<?php echo e($estado->id_estado); ?>">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay Estados disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/estados.blade.php ENDPATH**/ ?>