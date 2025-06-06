document.addEventListener("DOMContentLoaded", function () {
    // Asigna un evento de clic a cada botón con clase .btn-editar
    document.querySelectorAll('.btn-editarCategoria').forEach(boton => {
        boton.addEventListener('click', function(){
            const fila = this.closest('tr');
            const columnas = fila.querySelectorAll('td');

             // Extrae los valores de las columnas
            const id = columnas[0].textContent.trim();
            const nombre_categoria = columnas[2].textContent.trim();
            const descripcion_categoria = columnas[3].textContent.trim();

            document.getElementById('editar_id').value = id;
            document.getElementById('editar_nombre').value = nombre_categoria;
            document.getElementById('editar_descripcion').value = descripcion_categoria;
             // Actualiza la acción del formulario con la ruta correspondiente para actualizar la categoria
            document.getElementById('formActualizarCategoria').action = `/categoria/actualizar/${id}`;
        });       
    });
    
})