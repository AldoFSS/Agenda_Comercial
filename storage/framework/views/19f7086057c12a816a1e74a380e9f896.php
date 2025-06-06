
<?php $__env->startSection('contenido'); ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr id="categoria_<?php echo e($catg->id_categoria); ?>">
                        <td><?php echo e($catg->id_categoria); ?></td>
                        <td>
                            <?php if($catg->imagen_Categoria): ?>
                                <img src="<?php echo e(asset('imgCategoria/' . $catg->imagen_Categoria)); ?>" width="50">
                            <?php else: ?>
                               <img src="<?php echo e(asset('imgCategoria/img_default.png')); ?>" width="50">
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($catg->nombre_Categoria); ?></td>
                        <td><?php echo e($catg->descripcion); ?></td>
                        <td><?php echo e($catg->created_at); ?></td>
                        <td class=" row justify-content-center">
                            <ul class="opciones">
                                <li>
                                    <a title="Ver detalles del la categoria" href="#" class="btn btn-primary btn-editarCategoria"  data-bs-toggle="modal" data-bs-target="#editarCategoriaModal">
                                        <i class="fas fa-edit" title="Editar"></i>
                                    </a>
                                </li>
                                <li>      
                                    <a title="Eliminar Categoria" href="#" class="btn btn-danger btn-eliminar" data-tipo="categoria" data-id="<?php echo e($catg->id_categoria); ?>">
                                        <i class="fas fa-trash-alt" title="Eliminar"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay Categorias disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL CREAR -->
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form form method="POST" action="<?php echo e(route('categorias.crear')); ?>"  enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
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
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="editar_id" id="editar_id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaLabel">Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_Categoria" id="editar_nombre" value="<?php echo e($catg->nombre_Categoria ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion_categoria" id="editar_descripcion" value="<?php echo e($catg->descripcion ?? ''); ?>" required>
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
<?php $__env->stopSection(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_categoria.js']); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/categorias.blade.php ENDPATH**/ ?>