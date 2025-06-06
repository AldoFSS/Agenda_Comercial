
<?php $__env->startSection('contenido'); ?>
<div class="table-responsive">
<button type="button" class="btn btn-primary btn-crear" data-bs-toggle="modal" data-bs-target="#crearVentaModal">Nueva Venta</button>
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Cliente</th>
                <th class="centered">Usuario</th>
                <th class="centered">fecha venta</th>
                <th class="centered">fecha registro</th>
                <th class="centered">total</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr id="venta_<?php echo e($venta->id_venta); ?>">
                    <td><?php echo e($venta->id_venta); ?></td>
                    <td data-id="<?php echo e($venta->id_cli); ?>"><?php echo e($venta->Cliente ?? 'Sin cliente'); ?></td>
                    <td data-id="<?php echo e($venta->id_usr); ?>"><?php echo e($venta->Usuario ?? 'Sin usuario'); ?></td>
                    <td><?php echo e($venta->fecha_venta); ?></td>
                    <td><?php echo e($venta->created_at); ?></td>
                    <td><?php echo e($venta->total); ?></td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Ver detalles del la venta" href="#" class="btn btn-primary btn-editar" data-id="<?php echo e($venta->id_venta); ?>" data-bs-toggle="modal" data-bs-target="#editarVentaModal">
                                <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Eliminar Venta" href="#" class="btn btn-danger btn-eliminar" data-tipo="venta" data-id="<?php echo e($venta->id_venta); ?>">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay ventas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Crear Venta-->
<div class="modal fade" id="crearVentaModal" tabindex="-1" aria-labelledby="crearVentaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="<?php echo e(route('ventas.crear')); ?>">
      <?php echo csrf_field(); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearCitaModalLabel">Nueva Venta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="cliente">Cliente:</label>
            <select class="form-control" name="id_cliente" required>
              <option value="">Selecciona un cliente</option>
              <?php if(isset($clientes)): ?>
                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($cliente->id_cliente); ?>"><?php echo e($cliente->nombre_cliente); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="usuario">Usuario:</label>
            <select class="form-control" name="id_usuario" required>
              <option value="">Selecciona un usuario</option>
              <?php if(isset($usuarios)): ?>
                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($usuario->id_usuario); ?>"><?php echo e($usuario->nombre_usuario); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>
          </div>
          <table id="productosTable">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody>
          <tr>
            </tr>
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-agregar-fila >Agregar producto</button>
          <div class="mb-3">
            <label for="fecha_venta">Fecha Venta:</label>
            <input type="date" class="form-control" name="fecha_venta" required>
          </div>
          <div class="mb-3">
            <label>Total</label>
            <input type="number" class="form-control" name="total" step="0.01" id="total" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar venta</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!--Modal editarVenta-->
<div class="modal fade" id="editarVentaModal" tabindex="-1" aria-labelledby="editarVentaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <form method="POST" id="formActualizarVenta">
  <?php echo csrf_field(); ?>
  <?php echo method_field('PUT'); ?>
  <input type="hidden" name="editar_id" id="editar_id">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editarVentaModalLabel">Editar Venta</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body">
      <div class="mb-3">
        <label for="editar_cliente">Cliente:</label>
        <select class="form-control" name="id_cliente" id="editar_cliente" required>
          <option value="">Selecciona un cliente</option>
          <?php if(isset($clientes)): ?>
            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($cliente->id_cliente); ?>"><?php echo e($cliente->nombre_cliente); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="editar_usuario">Usuario:</label>
        <select class="form-control" name="id_usuario" id="editar_usuario" required>
          <option value="">Selecciona un usuario</option>
          <?php if(isset($usuarios)): ?>
            <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($usuario->id_usuario); ?>"><?php echo e($usuario->nombre_usuario); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="editar_fecha_venta">Fecha_venta:</label>
        <input type="date" class="form-control" name="fecha_venta" id="editar_fecha_venta" value="<?php echo e($venta->fecha_venta ?? ''); ?>" >
      </div>
      <table class="table" id="tablaDetalles">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
              <th>IVA</th>
              <th>Total</th>
              <th>Quitar</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-agregar-filaDetalles>Agregar producto</button>
      <div class="mb-3">
        <label>Total</label>
        <input type="number" class="form-control" name="total" step="0.01" id="editar_total" readonly>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-primary">Actualizar Venta</button>
    </div>
  </div>
</form>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_ventas.js']); ?>
<script>
    window.mensajeSuccess = <?php echo json_encode(session('success'), 15, 512) ?>;
    window.mensajeError = <?php echo json_encode(session('error'), 15, 512) ?>;
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/paginas/ventas.blade.php ENDPATH**/ ?>