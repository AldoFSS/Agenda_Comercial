document.addEventListener("DOMContentLoaded", function () {
    // Asigna un evento de clic a cada botón con clase .btn-editar
    document.querySelectorAll('.btn-editarZona').forEach(boton => {
        boton.addEventListener('click', function () {
            const fila = this.closest('tr');
            const columnas = fila.querySelectorAll('td');

            // Extrae los valores de las columnas
            const id = columnas[0].textContent.trim();                   
            const nombre_zona = columnas[1].textContent.trim();    
            const descripcion_zona = columnas[2].textContent.trim();   

            // Obtiene los datos de las zonas y los coloca en el formulario de edición
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_zona').value = nombre_zona;
            document.getElementById('editar_descripcion').value = descripcion_zona;
             // Actualiza la acción del formulario con la ruta correspondiente para actualizar la zona
            document.getElementById('formActualizarZona').action = `/zonas/actualizar/${id}`;
        });
    });
});
