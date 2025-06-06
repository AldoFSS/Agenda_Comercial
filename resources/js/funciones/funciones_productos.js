
document.addEventListener("DOMContentLoaded", function () {
    const codigoInputs = document.querySelectorAll('#codigoProducto, #editar_codigo');
    const barcodesSVG = document.querySelectorAll('#barcode, #barcode_editar');

    codigoInputs.forEach((input, index) => {
        const svg = barcodesSVG[index];
        input.addEventListener('input', function () {
            if (input.value.trim() !== '') {
            JsBarcode(svg, input.value, {
                format: "CODE128",
                lineColor: "#000",
                width: 2,
                height: 50,
                displayValue: true
            });
        } else {
            svg.innerHTML = ''; 
        }
    });
    });

    // Asigna eventos de clic a todos los botones con clase .btn-editar
    document.querySelectorAll('.btn-editar').forEach(boton => {
        boton.addEventListener('click', function () {           
            const fila = this.closest('tr');

            const columnas = fila.querySelectorAll('td');

            // Extrae los valores de las columnas
            const id = columnas[0].textContent.trim();                        
            const nombre_producto = columnas[2].textContent.trim();       

            const stock = parseInt(columnas[6].textContent.trim());
            const precio_unitario = columnas[7].textContent.trim();
            const precio_venta = columnas[8].textContent.trim();
            const IVA = columnas[9].textContent.trim();
            const codigo = columnas[10].textContent.trim();
           
            // Obtiene los datos de los productos y los coloca en el formulario de edición
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_nombre').value = nombre_producto;
            document.getElementById('editar_categoria').value = columnas[3].dataset.id;
            document.getElementById('editar_subcategoria').value = columnas[4].dataset.id;
            document.getElementById('editar_proveedor').value = columnas[11].dataset.id;
            document.getElementById('editar_marca').value = columnas[5].dataset.id;
            document.getElementById('editar_stock').value = stock;
            document.getElementById('editar_precio_unitario').value = precio_unitario;
            document.getElementById('editar_precio_venta').value = precio_venta;
            document.getElementById('editar_IVA_producto').value = IVA;
            document.getElementById('editar_codigo').value = codigo;

              // Generar el código de barras para el campo editar_codigo
            const svgEditar = document.getElementById('barcode_editar');
            if (codigo.trim() !== '') {
                JsBarcode(svgEditar, codigo, {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 2,
                    height: 50,
                    displayValue: true
                });
            } else {
                svgEditar.innerHTML = '';
            }

             // Actualiza la acción del formulario con la ruta correspondiente para actualizar el producto
            document.getElementById('formActualizarProducto').action = `/productos/actualizar/${id}`;
        });
    });
});
