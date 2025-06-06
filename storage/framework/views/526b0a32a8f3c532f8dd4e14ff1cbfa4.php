
<?php $__env->startSection('contenido'); ?>
<!-- Modal -->
<div class="table-responsive">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">Nuevo Producto</button>
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Imagen</th>
                <th class="centered">Producto</th>
                <th class="centered">Categoria</th>
                <th class="centered">SubCategoria</th>
                <th class="centered">Marca</th>
                <th class="centered">Cantidad</th>
                <th class="centered">precio_unitario</th>
                <th class="centered">precio_venta</th>
                <th class="centered">IVA</th>
                <th class="centered">Codigo</th>
                <th class="centered">Proveedor</th>
                <th class="centered">Fecha_registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr id="producto_<?php echo e($producto->id_producto); ?>">
                    <td><?php echo e($producto->id_producto); ?></td>
                    <td>
                        <?php if($producto->imagen_producto): ?>
                            <img src="<?php echo e(asset('imgProductos/' . $producto->imagen_producto)); ?>" width="50">
                        <?php else: ?>
                            <img src="<?php echo e(asset('imgProductos/img_default.png')); ?>" width="50">
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($producto->nombre_producto); ?></td>
                    <td data-id="<?php echo e($producto->id_catg); ?>"><?php echo e($producto->Categoria); ?></td>
                    <td data-id="<?php echo e($producto->id_subcatg); ?>"><?php echo e($producto->Subcategoria); ?></td>
                    <td data-id="<?php echo e($producto->id_marc); ?>"><?php echo e($producto->Marca); ?></td>
                    <td><?php echo e($producto->stock); ?></td>
                    <td><?php echo e($producto->precio_unitario); ?></td>
                    <td><?php echo e($producto->precio_venta); ?></td>
                    <td><?php echo e($producto->IVA_producto); ?></td>
                    
                    <td><?php echo e($producto->codigo); ?></td>
                    <td data-id="<?php echo e($producto-> id_proveedor); ?>"><?php echo e($producto->proveedor); ?></td>
                    <td><?php echo e($producto->created_at); ?></td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles del Producto" href="#" class="btn btn-primary btn-editar"  data-bs-toggle="modal" data-bs-target="#editarProductoModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Producto" class="btn btn-danger btn-eliminar" data-tipo="producto" data-id="<?php echo e($producto->id_producto); ?>">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay Productos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- MODAL CREAR-->
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="<?php echo e(route('productos.crear')); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="id" id="productoId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="insertarProductoLabel">Nuevo Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="form-label">Nombre:</label>
              <input type="text" class="form-control" name="nombre_producto" id="nombreProducto" required>
            </div>

            <div class="col-12 col-md-6">
              <label for="editar_usuario">Proveedor:</label>
              <select class="form-control" name="id_proveedor" required>
                <option value="">Selecciona un proveedor</option>
                <?php if(isset($proveedores)): ?>
                  <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($proveedor->id_cliente); ?>"><?php echo e($proveedor->nombre_comercial); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="col-12 col-md-4">
              <label for="editar_usuario">Categoria:</label>
              <select class="form-control" name="id_categoria" required>
                <option value="">Selecciona una Categoria</option>
                <?php if(isset($categorias)): ?>
                  <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($categoria->id_categoria); ?>"><?php echo e($categoria->nombre_Categoria); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="col-12 col-md-4">
              <label for="editar_usuario">Subcategoria:</label>
              <select class="form-control" name="id_subcategoria" required>
                <option value="">Selecciona una subcategoria</option>
                <?php if(isset($subcategorias)): ?>
                  <?php $__currentLoopData = $subcategorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($subcategoria->id_subcategoria); ?>"><?php echo e($subcategoria->nombre_subcategoria); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="col-12 col-md-4">
              <label for="editar_usuario">Marca:</label>
              <select class="form-control" name="id_marca" required>
                <option value="">Selecciona una Marca</option>
                <?php if(isset($marcas)): ?>
                  <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($marca->id_marca); ?>"><?php echo e($marca->nombre_marca); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Imagen:</label>
              <input type="file" class="form-control" name="imagen_producto" id="imagenProducto" accept="image/*" required>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Stock:</label>
              <input type="number" class="form-control" name="stock" id="stockProducto" required>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Código de barras:</label>
              <input type="text" class="form-control" name="codigo" id="codigoProducto" required>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center"  
            style="background-color: #f8f9fa; border: 1px solid #ddd; height: 60px; min-height: 80px; position: relative;">
              <svg id="barcode"></svg>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">Precio:</label>
              <input type="number" class="form-control" name="precio_unitario" id="precioUnitarioProducto" step="0.01" required>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">Precio Venta:</label>
              <input type="number" class="form-control" name="precio_venta" id="precioVentaProducto" step="0.01" required>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label">IVA:</label>
              <input type="number" class="form-control" name="IVA_producto" id="IVAProducto" step="0.01" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDITAR-->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoLabel" aria-hidden="true"> 
  <div class="modal-dialog modal-dialog-centered modal-lg"> 
    <form method="post" id="formActualizarProducto" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <input type="hidden" name="id" id="editar_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarProductoLabel">Editar Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row g-3"> 
              <div class="col-12 col-md-6">
                <label class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre_producto" id="editar_nombre" required>
              </div>
              <div class="col-12 col-md-6">
                <label>Proveedor:</label>
                <select class="form-select" name="id_proveedor" id="editar_proveedor" required>
                  <option value="">Selecciona un proveedor</option>
                  <?php if(isset($proveedores)): ?>
                    <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($proveedor->id_cliente); ?>"><?php echo e($proveedor->nombre_comercial); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="col-12 col-md-4">
                <label>Categoria:</label>
                <select class="form-select" name="id_categoria" id="editar_categoria" required>
                  <option value="">Selecciona una Categoria</option>
                  <?php if(isset($categorias)): ?>
                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($categoria->id_categoria); ?>"><?php echo e($categoria->nombre_Categoria); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="col-12 col-md-4">
                <label>SubCategoria:</label>
                <select class="form-select" name="id_subcategoria" id="editar_subcategoria" required>
                  <option value="">Selecciona una subcategoria</option>
                  <?php if(isset($subcategorias)): ?>
                    <?php $__currentLoopData = $subcategorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($subcategoria->id_subcategoria); ?>"><?php echo e($subcategoria->nombre_subcategoria); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="col-12 col-md-4">
                <label>Marca:</label>
                <select class="form-select" name="id_marca" id="editar_marca" required>
                  <option value="">Selecciona una Marca</option>
                  <?php if(isset($marcas)): ?>
                    <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($marca->id_marca); ?>"><?php echo e($marca->nombre_marca); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen_producto" id="editar_imagenProducto" accept="image/*">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Stock:</label>
                <input type="number" class="form-control" name="stock" id="editar_stock" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Codigo de barras:</label>
                <input type="text" class="form-control" name="codigo" id="editar_codigo" required>
              </div>
              <div class="col-12 col-md-6 d-flex justify-content-center align-items-center"
               style="background-color: #f8f9fa; border: 1px solid #ddd; min-height: 80px; position: relative;">
                <svg id="barcode_editar"></svg>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label">Precio:</label>
                <input type="number" class="form-control" name="precio_unitario" id="editar_precio_unitario" step="0.01" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label">Precio Venta:</label>
                <input type="number" class="form-control" name="precio_venta" id="editar_precio_venta" step="0.01" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label">IVA:</label>
                <input type="number" class="form-control" name="IVA_producto" id="editar_IVA_producto" step="0.01" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_productos.js']); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/productos.blade.php ENDPATH**/ ?>