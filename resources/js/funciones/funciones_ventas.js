
let indexDetalles = 1;
let productosDisponibles = [];
let productosData = {};
let index = 0;
document.addEventListener("DOMContentLoaded", function () {

  
  document.querySelector('#productosTable tbody').addEventListener('change', function(event){
    if(event.target && event.target.matches('select[name^="productos"]')){
      actualizarProducto(event);
    }
  });

  //Carga los productos y agrega una nueva fila por defecto
  document.querySelectorAll('.btn-crear').forEach(boton => {
    boton.addEventListener('click', async function() {
      try {
        // Obtiene la lista de productos desde la BD 
        const resProductos = await fetch('/productos/lista');
        productosDisponibles = await resProductos.json();
        productosDisponibles.forEach(p => {
          productosData[p.id_producto] = p;
        });
        agregarFila();
      } catch (error) {
        console.error("Error cargando productos:", error);
      }
    });
  });
  // Al hacer click en btn editar carga los detalles de la venta
  document.querySelectorAll('.btn-editar').forEach(boton => {
    boton.addEventListener('click', async function () {
      const idVenta = this.dataset.id; 
      const tbody = document.querySelector("#tablaDetalles tbody");
      tbody.innerHTML = "";
      indexDetalles = 0; 
      try {
        // Carga los productos para tener opciones en el select
        const resProductos = await fetch('/productos/lista');
        productosDisponibles = await resProductos.json();
        productosDisponibles.forEach(p => {
          productosData[p.id_producto] = p;
        });

        // Carga los detalles de la venta seleccionada
        const resDetalles = await fetch(`/ventas/detalles/${idVenta}`);
        const detalles = await resDetalles.json();

        detalles.forEach(item => {
          const fila = document.createElement("tr");

          let opciones = '<option value="">Producto</option>';
          productosDisponibles.forEach(prod => {
            const selected = prod.id_producto == item.id_prd ? 'selected' : '';
            opciones += `<option value="${prod.id_producto}" ${selected}>${prod.nombre_producto}</option>`;
          });

          // Inserta un contenido HTML en la fila con datos del detalle
          fila.innerHTML = `
            <td>
              <select class="form form-control" name="productos[${indexDetalles}][id_producto]" required>
                ${opciones}
              </select>
            </td>
            <td><input type="number" class="form form-control" value="${item.cantidad}" name="productos[${indexDetalles}][cantidad]" required></td>
            <td><input type="number" class="form form-control" step="0.01" value="${item.precio_venta}" name="productos[${indexDetalles}][precio_venta]" readonly></td>
            <td><input type="number" class="form form-control" step="0.01" value="${item.subtotal}" name="productos[${indexDetalles}][subtotal]" readonly></td>
            <td><input type="number" class="form form-control" step="0.01" value="${item.IVA}" name="productos[${indexDetalles}][IVA]" readonly></td>
            <td><input type="number" class="form form-control" step="0.01" value="${item.total}" name="productos[${indexDetalles}][total]" readonly></td>
            <td><button type="button" class="btn btn-primary btn-eliminar-filaDetalles">X</button></td> 
          `;

          // Evento para eliminar fila con confirmación y actualiza el total tras eliminar
          fila.querySelector('.btn-eliminar-filaDetalles').addEventListener('click', function () {
            confirmarEliminarFila(this, () => {
              fila.remove();
              calcularTotal();
            });
          });

          // actualiza los subtotales cuando cambia las cantidades
          const inputCantidad = fila.querySelector('input[name$="[cantidad]"]');
          inputCantidad.addEventListener('input', () => {
            actualizarSubtotalFila(fila);
          });

          tbody.appendChild(fila);
          actualizarSubtotalFila(fila);

          indexDetalles++;
        });

        //Actualiza el producto si cambia el select dentro de la tabla detalles
        tbody.addEventListener('change', function (event) {
          if (event.target && event.target.matches('select[name^="productos"]')) {
            actualizarProducto(event);
          }
        });


        const fila = this.closest('tr');
        const columnas = fila.querySelectorAll('td');

       // Obtiene los datos de las ventas y los coloca en el formulario de edición
        document.getElementById('editar_id').value = columnas[0].textContent.trim();
        document.getElementById('editar_cliente').value = columnas[1].dataset.id;
        document.getElementById('editar_usuario').value = columnas[2].dataset.id;
        document.getElementById('editar_fecha_venta').value = columnas[3].textContent.trim();
        document.getElementById('editar_total').value = columnas[5].textContent.trim();

         // Actualiza la acción del formulario con la ruta correspondiente para actualizar la venta
        document.getElementById('formActualizarVenta').action = `/ventas/actualizar/${idVenta}`;
      } catch (error) {
        console.error("Error cargando productos o detalles:", error);
      }
    });
  });

  // Botón para agregar una nueva fila en detalles de venta
  const botonDetalles = document.querySelector('[data-agregar-filaDetalles]');
  if (botonDetalles) {
    botonDetalles.addEventListener('click', agregarFilaDetalles);
  }

  // Botón para agregar una nueva fila en una venta nueva
  const botonAgregarFila = document.querySelector('[data-agregar-fila]');
  if (botonAgregarFila) {
    botonAgregarFila.addEventListener('click', agregarFila);
  }
});

// Genera las opciones HTML para los selects de productos según los productosDisponibles de la BD
function generarOpcionesProductos() {
  return productosDisponibles.map(p =>
    `<option value="${p.id_producto}">${p.nombre_producto}</option>`
  ).join('');
}

// Función que se ejecuta cuando cambia el producto del select actualiza el precio automáticamente
function actualizarProducto(event) {
  const selectElement = event.target; 
  const id_producto = selectElement.value; 
  const fila = selectElement.closest('tr'); 
  const inputPrecio = fila.querySelector('input[name$="[precio_venta]"]'); 

  // Si no hay producto seleccionado o no existe en datos, limpia el precio y subtotal
  if (!id_producto || !productosData[id_producto]) {
    inputPrecio.value = "";
    actualizarSubtotalFila(fila); 
    return;
  }

  // Obtiene el precio del producto y actualiza el input precio
  const precio = parseFloat(productosData[id_producto].precio_venta);
  inputPrecio.value = precio.toFixed(2);

  actualizarSubtotalFila(fila);
}

// Calcula el total sumando subtotales de todas las filas de ambas tablas
function calcularTotal() {
  let total = 0;
  
  document.querySelectorAll('#tablaDetalles tbody tr, #productosTable tbody tr').forEach(fila => {
    const totalProductoInput =  fila.querySelector('input[name$="[total]"]');

    total += parseFloat(totalProductoInput?.value) || 0;
  });

  // Actualiza los inputs del total 
  const totalInputDetalles = document.getElementById('editar_total');
  const totalInput = document.getElementById('total');
  if (totalInputDetalles) totalInputDetalles.value = total.toFixed(2);
  if (totalInput) totalInput.value = total.toFixed(2);
}

// Actualiza el subtotal, IVA y total en una fila cuando cambian cantidad o precio
function actualizarSubtotalFila(fila) {
  const inputCantidad = fila.querySelector('input[name$="[cantidad]"]');
  const inputPrecio = fila.querySelector('input[name$="[precio_venta]"]');
  const inputSubtotal = fila.querySelector('input[name$="[subtotal]"]');
  const inputIVA = fila.querySelector('input[name$="[IVA]"]');
  const inputTotal = fila.querySelector('input[name$="[total]"]');
  
  const cantidad = parseFloat(inputCantidad?.value) || 0;
  const precio = parseFloat(inputPrecio?.value) || 0;
  const subtotal = cantidad * precio;
  const IVA = subtotal * 0.16; 
  const totalDetalles = subtotal + IVA;

  
  inputSubtotal.value = subtotal.toFixed(2);
  inputIVA.value = IVA.toFixed(2);
  inputTotal.value = totalDetalles.toFixed(2);

  // Recalcula el total general de todas las filas
  calcularTotal();
}

// Muestra un sweetAlert de confirmación para eliminar una fila
function confirmarEliminarFila(btn, callback) {
  Swal.fire({
    title: '¿Estás seguro de eliminar el producto?',
    text: "No podrás revertir esto",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      callback();
      Swal.fire('Eliminado', 'El producto ha sido eliminado.', 'success');
    }
  });
}

// Función para agregar una nueva fila en la tabla principal para Crear una Venta
function agregarFila() { 
  const table = document.querySelector('#productosTable tbody');
  const fila = table.insertRow();

  // Llena la fila con inputs y select para producto, cantidad, precio, subtotal, IVA y total
  fila.innerHTML = `
    <td>
      <select class="form form-control" name="productos[${index}][id_producto]" required>
        <option value="">Producto</option>
        ${generarOpcionesProductos()}
      </select>
    </td>
    <td><input type="number" class="form form-control" name="productos[${index}][cantidad]" required></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${index}][precio_venta]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${index}][subtotal]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${index}][IVA]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${index}][total]" readonly></td>
    <td><button type="button" class="btn btn-primary btn-eliminar-fila">X</button></td>
  `;

  // Evento para eliminar una fila con confirmación y actualizar el total tras eliminar
  fila.querySelector('.btn-eliminar-fila').addEventListener('click', function () {
    confirmarEliminarFila(this, () => {
      fila.remove();
      calcularTotal();
    });
  });

  // Evento para actualizar subtotal cuando cambie la cantidad
  const inputCantidad = fila.querySelector('input[name$="[cantidad]"]');
  inputCantidad.addEventListener('input', () => {
    actualizarSubtotalFila(fila);
  });

  index++; 
}

// Función para agregar una nueva fila en la tabla de Actualizar una Venta
function agregarFilaDetalles() {
  const table = document.querySelector('#tablaDetalles tbody');
  const fila = table.insertRow();
  const selectOptions = generarOpcionesProductos();

  fila.innerHTML = `
    <td>
      <select class="form form-control" name="productos[${indexDetalles}][id_producto]" required>
        <option value="">Producto</option>
        ${selectOptions}
      </select>
    </td>
    <td><input type="number" class="form form-control" name="productos[${indexDetalles}][cantidad]" required></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${indexDetalles}][precio_venta]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${indexDetalles}][subtotal]" readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${indexDetalles}][IVA]"  readonly></td>
    <td><input type="number" class="form form-control" step="0.01" name="productos[${indexDetalles}][total]"  readonly></td>
    <td><button type="button" class="btn btn-primary btn-eliminar-filaDetalles">X</button></td>
  `;

  // Evento para eliminar una fila con confirmación
  fila.querySelector('.btn-eliminar-filaDetalles').addEventListener('click', function () {
    confirmarEliminarFila(this, () => {
      fila.remove();
      calcularTotal();
    });
  });

  // Evento para actualizar subtotal cuando cambie la cantidad
  const inputCantidad = fila.querySelector('input[name$="[cantidad]"]');
  inputCantidad.addEventListener('input', () => {
    actualizarSubtotalFila(fila);
  });

  indexDetalles++; 
}
