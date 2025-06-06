document.addEventListener("DOMContentLoaded", function () {
    const estadoSelects = document.querySelectorAll('#Select_estado, #editar_estado');
    const municipioSelects = document.querySelectorAll('#Select_municipio, #editar_municipio');
    estadoSelects.forEach((select) => {
        select.addEventListener('change', async () => {
            const estado = select.value;
            municipioSelects.forEach(municipioSelect => {
                municipioSelect.innerHTML = '<option value="">Cargando...</option>';
            });
            if (estado !== '') {
                try {
                    //Realiza una peticion al servidor para obtener los municipios del id del estado
                    const response = await fetch(`clientes/buscarMunicipio/${estado}`);
                    const data = await response.json();

                    municipioSelects.forEach(municipioSelect => {
                        municipioSelect.innerHTML = '<option value="">-- Selecciona --</option>';
                        //Realiza las opciones de los municipios
                        data.forEach(opcion => {
                            const option = document.createElement('option');
                            option.value = opcion.id_municipio;
                            option.textContent = opcion.municipio;
                            municipioSelect.appendChild(option);
                        });
                    });
                } catch (error) {
                    console.error('Error al cargar opciones:', error);
                    municipioSelects.forEach(municipioSelect => {
                        municipioSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
                }
            } else {
                municipioSelects.forEach(municipioSelect => {
                    municipioSelect.innerHTML = '<option value="">-- Selecciona --</option>';
                });
            }
        });
    });
    // Asigna un evento de clic a cada botón con clase .btn-editar
    document.querySelectorAll('.btn-editarCliente').forEach(boton => {
        boton.addEventListener('click', function () {  
            const fila = this.closest('tr');
            const columnas = fila.querySelectorAll('td');
             // Extrae los valores de las columnas
            const id = columnas[0].textContent.trim();
            const nombre_cliente = columnas[2].textContent.trim();
            const nombre_comercial = columnas[3].textContent.trim();
            const rol = columnas[4].textContent.trim();
            const telefono = columnas[5].textContent.trim();
            const correo = columnas[6].textContent.trim();
            const codigo_postal = columnas[7].textContent.trim();
            const colonia = columnas[8].textContent.trim();
            const calle = columnas[9].textContent.trim();
            const estado = columnas[10].dataset.id;
            const municipio = columnas[11].dataset.id;

            // Obtiene los datos de los clientes y los coloca en el formulario de edición
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_nombre').value = nombre_cliente;
            document.getElementById('editar_nombre_comercial').value = nombre_comercial;
            document.getElementById('editar_telefono').value = telefono;
            document.getElementById('editar_correo').value = correo;
            document.getElementById('editar_codigo_postal').value = codigo_postal;
            document.getElementById('editar_rol').value = rol;
            document.getElementById('editar_colonia').value = colonia;
            document.getElementById('editar_calle').value = calle;
            document.getElementById('editar_estado').value = estado;
             // Actualiza la acción del formulario con la ruta correspondiente para actualizar el cliente
            document.getElementById('formActualizarCliente').action = `/clientes/actualizar/${id}`;

            //realiza una peticion para obtener los municipios en base en el id del estado
            fetch(`clientes/buscarMunicipio/${estado}`)
                .then(response => response.json())
                .then(data => {
                    const municipioSelect = document.getElementById('editar_municipio');
                    municipioSelect.innerHTML = '<option value="">-- Selecciona --</option>';
                    data.forEach(opcion => {
                        const option = document.createElement('option');
                        option.value = opcion.id_municipio;
                        option.textContent = opcion.municipio;
                        municipioSelect.appendChild(option);
                });
                municipioSelect.value = municipio;
            })
            .catch(error => {
                console.error('Error al cargar municipios:', error);
            });
        });
        
    });

});
