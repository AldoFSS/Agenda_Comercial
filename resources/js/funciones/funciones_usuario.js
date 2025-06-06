document.addEventListener("DOMContentLoaded", function () {
    // Asigna un evento de clic a cada botón con clase .btn-editarUsuario
    document.querySelectorAll('.btn-editarUsuario').forEach(boton => {
        boton.addEventListener('click', function () {

    
            const fila = this.closest('tr');
            const columnas = fila.querySelectorAll('td');

          // Obtiene los datos de los usuarios y los coloca en el formulario de edición
            const id = columnas[0].textContent.trim();                   
            const nombre_usuario = columnas[2].textContent.trim();    
            const telefono = columnas[3].textContent.trim();             
            const correo = columnas[4].textContent.trim();               
            const rol = columnas[5].textContent.trim();                  
            // Asigna los valores extraídos a los campos del formulario de edición
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_nombre').value = nombre_usuario;
            document.getElementById('editar_telefono').value = telefono;
            document.getElementById('editar_correo').value = correo;
            document.getElementById('editar_rol').value = rol;

             // Actualiza la acción del formulario con la ruta correspondiente para actualizar el usuario
            document.getElementById('formActualizarUsuario').action = `/usuarios/actualizar/${id}`;
        });
    });
});
