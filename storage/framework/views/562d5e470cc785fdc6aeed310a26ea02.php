<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset(path: 'css/styles.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <title>Document</title>
</head>
<body>
<div class="wrapper">
    <aside id="sidebar" class="p-3">
      <div class="d-flex">
        <a class="toggle-btn1" href=""><i class="fas fa-home" title="Inicio"></i></a>
        <div class="sidebar-logo">
        </div>
      </div>
      <ul class="sidebar-nav">
        <?php if(auth()->guard()->check()): ?>
          <?php if(Auth::user()->rol === 'Administrador'): ?>
            <li class="sidebar-item">
              <a href="<?php echo e(route('usuarios')); ?>" class="sidebar-link">
                <i class="fas fa-user" title="Usuario"></i>
                <span>Usuarios</span>
              </a>
            </li>
          <?php endif; ?>
          <?php if(Auth::user()->rol === 'Administrador' ): ?>
            <li class="sidebar-item">
              <a href="<?php echo e(route('clientes')); ?>" class="sidebar-link">
                <i class="fas fa-users" title="Cliente"></i>
                <span>Clientes</span>
              </a>
            </li>
          <?php endif; ?>
          <?php if(Auth::user()->rol === 'Administrador' || Auth::user()->rol === 'Asesor Comercial' || Auth::user()->rol === 'Gerente' ): ?>
          <li class="sidebar-item">
            <a href="<?php echo e(route('citas')); ?>" class="sidebar-link">
              <i class="fas fa-calendar-check" title="Citas"></i>
              <span>Citas</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if(Auth::user()->rol === 'Administrador' || Auth::user()->rol === 'Asesor Comercial'|| Auth::user()->rol === 'Gerente'): ?>
          <li class="sidebar-item">
            <a href="<?php echo e(route('ventas')); ?>" class="sidebar-link">
              <i class="fas fa-file-invoice-dollar" title="Venta"></i>
              <span>Ventas</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if(Auth::user()->rol === 'Administrador' || Auth::user()->rol === 'Gerente'): ?>
          <li class="sidebar-item">
            <a href="<?php echo e(route('productos')); ?> " class="sidebar-link">
              <i class="fas fa-box-open" title="Productos"></i>
              <span>Productos</span>
            </a>
          </li>
          <?php endif; ?>
        <?php if(Auth::user()->rol === 'Administrador'): ?>
        <li class="sidebar-item">
          <a href="<?php echo e(route('grafico')); ?>" class="sidebar-link">
             <i class="fas fa-chart-line" title="Grafico"></i>
             <span>Grafico</span>
          </a>
        </li>
        <?php endif; ?>
        <li class="sidebar-item">
          <a href="#catalogo" class="sidebar-link collapsed" data-bs-toggle="collapse"
            data-bs-target="#catalogo" aria-expanded="false" aria-controls="catalogo">
            <i class="fas fa-folder-open"></i>
            <span>Catalogo</span>
          </a>          
          <ul id="catalogo" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
              <a href="<?php echo e(route('estados')); ?>" class="sidebar-link">
                <i class="fas fa-map-marker-alt"></i>
                <span>Estados</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="<?php echo e(route('municipios')); ?>" class="sidebar-link">
                <i class="fas fa-city"></i>
                <span>Municipios</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="<?php echo e(route('zonas')); ?>" class="sidebar-link">
                <i class="fas fa-map"></i>
                <span>Zonas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="<?php echo e(route('categorias')); ?>" class="sidebar-link">
                <i class="fas fa-th-large"></i>
                <span>Categorias</span>
              </a>
            </li>
             <li class="sidebar-item">
              <a href="<?php echo e(route('subcategorias')); ?>" class="sidebar-link">
                <i class="fas fa-th"></i>
                <span>Subcategorias</span>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
      <div class="sidebar-footer">
        <a  href="<?php echo e(route('login')); ?>" class="sidebar-link">
        <i class="fas fa-sign-out-alt" title="Cerrar sesión"></i>
          <span>Logout</span>
        </a>
      </div>
    </aside>
    <div class="main">
      <div class="text-center">
        <div class="content-wrapper">
          <nav class="navbar navbar-expand-lg navbar-light bg-light px-2 col-12 col-md-7">
            <a class="toggle-btn"><i class="fas fa-bars" title="Menú"></i></a>
            <h2 class="ms-auto d-flex">Agenda Comercial</h2>
          </nav>
          <section class="main-content p-3">
            <div class="container my-2">
              
              <?php echo $__env->yieldContent('contenido'); ?>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  <footer class="bg-dark text-white text-center py-3">
    <small>&copy; 2025 Mi Sistema. Todos los derechos reservados.</small>
  </footer>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/js/funciones/funciones_pagina.js']); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

</body>
</html><?php /**PATH C:\Users\Aldo\AgendaComercialV2.5\resources\views/layouts/app.blade.php ENDPATH**/ ?>