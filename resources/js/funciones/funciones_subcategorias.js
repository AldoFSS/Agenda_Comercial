document.addEventListener("DOMContentLoaded", function () {
    // Asigna un evento de clic a cada botón con clase .btn-editar
    document.querySelectorAll('.btn-editarsubCategoria').forEach(boton => {
        boton.addEventListener('click', function() {
            const fila = this.closest('tr');
            const columnas = fila.querySelectorAll('td');

             // Extrae los valores de las columnas
            const id = columnas[0].textContent.trim();
            const nombre_subcategoria = columnas[2].textContent.trim();
            const descripcion_subcategoria = columnas[4].textContent.trim();
            // Obtiene los datos de las subcategorias y los coloca en el formulario de edición
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_nombre').value = nombre_subcategoria;
            document.getElementById('editar_descripcion').value = descripcion_subcategoria;
            document.getElementById('editar_categoria').value = columnas[3].dataset.id;
             // Actualiza la acción del formulario con la ruta correspondiente para actualizar la subcategoria
            document.getElementById('formActualizarsubCategoria').action = `/subcategoria/actualizar/${id}`;
        });
    });
});
