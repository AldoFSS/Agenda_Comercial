document.addEventListener("DOMContentLoaded", function () {

    // Asigna un evento de clic a cada botón con clase .btn-editar
    document.querySelectorAll('.btn-editar').forEach(boton => {
        boton.addEventListener('click', function () {

    
            const fila = this.closest('tr');
            const columnas = fila.querySelectorAll('td');

            // Extrae los valores de las columnas
            const id = columnas[0].textContent.trim();                   
            const nombre_municipio = columnas[1].textContent.trim();              
            // Asigna los valores extraídos a los campos del formulario de edición
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_municipio').value = nombre_municipio;
            document.getElementById('editar_estado').value = columnas[2].dataset.id;
             // Actualiza la acción del formulario con la ruta correspondiente para actualizar el municipio
            document.getElementById('formActualizarMunicipio').action = `/municipios/actualizar/${id}`;
        });
    });
});
