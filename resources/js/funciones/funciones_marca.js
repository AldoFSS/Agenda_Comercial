document.addEventListener("DOMContentLoaded", function () {

    // Asigna un evento de clic a cada botón con clase .btn-editar
    document.querySelectorAll('.btn-editarMarca').forEach(boton => {
        boton.addEventListener('click', function () {

    
            const fila = this.closest('tr');
            const columnas = fila.querySelectorAll('td');

            // Extrae los valores de las columnas
            const id = columnas[0].textContent.trim();                   
            const nombre_marca = columnas[1].textContent.trim();    
            const descripcion_marca = columnas[2].textContent.trim();              
            // Asigna los valores extraídos a los campos del formulario de edición
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_marca').value = nombre_marca;
            document.getElementById('editar_descripcion').value = descripcion_marca;
            // Actualiza la acción del formulario con la ruta correspondiente para actualizar la marca
            document.getElementById('formActualizarMarca').action = `/marcas/actualizar/${id}`;
        });
    });
});
