
<?php $__env->startSection('contenido'); ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $subcategorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr id="subcategoria_<?php echo e($subctg->id_subcategoria); ?>">
                        <td><?php echo e($subctg->id_subcategoria); ?></td>
                        <td>
                            <?php if($subctg->imagen_subcategoria): ?>
                                <img src="<?php echo e(asset('imgSubCategoria/' . $subctg->imagen_subcategoria)); ?>" width="50">
                            <?php else: ?>
                                <img src="<?php echo e(asset('imgSubCategoria/img_default.png')); ?>" width="50">
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($subctg->nombre_subcategoria); ?></td>
                        <td data-id="<?php echo e($subctg->id_ctg); ?>"><?php echo e($subctg->Categoria ?? 'Sin Categoria'); ?></td>
                        <td><?php echo e($subctg->descripcion_subcategoria); ?></td>
                        <td><?php echo e($subctg->created_at); ?></td>
                        <td class=" row justify-content-center">
                            <ul class="opciones">
                                <li>
                                    <a title="Ver detalles del la subcategoria" href="#" class="btn btn-primary btn-editarsubCategoria" data-id="<?php echo e($subctg->id_subcategoria); ?>" data-bs-toggle="modal" data-bs-target="#editarsubCategoriaModal">
                                        <i class="fas fa-edit" title="Editar"></i>
                                    </a>
                                </li>
                                <li>      
                                    <a title="Eliminar subcategoria" href="#" class="btn btn-danger btn-eliminar" data-tipo="subcategoria" data-id="<?php echo e($subctg->id_subcategoria); ?>">
                                        <i class="fas fa-trash-alt" title="Eliminar"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay SubCategorias disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- MODAL CREAR -->
<div class="modal fade" id="crearsubCategoriaModal" tabindex="-1" aria-labelledby="crearsubCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('subcategorias.crear')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
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
                        <?php if(isset($categorias)): ?>
                            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id_categoria); ?>"><?php echo e($categoria->nombre_Categoria); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
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
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="editar_id" id="editar_id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarsubCategoriaLabel">Editar subCategoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre_subcategoria" id="editar_nombre" value="<?php echo e($catg->nombre_Categoria ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" name="descripcion_subcategoria" id="editar_descripcion" value="<?php echo e($catg->descripcion ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="editar_categoria">Categoria</label>
                    <select class="form-control" name="id_categoria" id="editar_categoria" required>
                        <option value="">Seleccione una Categoria</option>
                        <?php if(isset($categorias)): ?>
                            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id_categoria); ?>"><?php echo e($categoria->nombre_Categoria); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_subcategorias.js']); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/subcategorias.blade.php ENDPATH**/ ?>