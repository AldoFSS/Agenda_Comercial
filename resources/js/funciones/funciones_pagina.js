document.addEventListener("DOMContentLoaded", function () {

  // Asigna un evento de clic a cada botón con clase .btn-editarUsuario
  document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-eliminar')) {
      const boton = e.target.closest('.btn-eliminar');
      const tipo = boton.dataset.tipo; // Tipo del elemento a eliminar (usuario, producto, cliente, venta)
      const id = boton.dataset.id;     // ID del elemento a eliminar
      eliminarElemento(tipo, id);      // Llama a la función para confirmar y procesar la eliminación
    }
  });

  // Función para mostrar confirmación y realizar la eliminación mediante fetch
  function eliminarElemento(tipo, id) {
    Swal.fire({
      title: `¿Estás seguro de eliminar el ${tipo}?`,
      text: "No podrás revertir esta acción.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`/eliminar/${tipo}/${id}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
          }
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Eliminado',
              text: `El ${tipo} fue eliminado`,
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
            const fila = document.getElementById(`${tipo}_${id}`);
            if(fila) fila.remove();
          } else {
            Swal.fire("Error", data.message || "No se pudo eliminar", "error");
          }
        })
        .catch(() => Swal.fire("Error", "Error en la solicitud", "error"));
      }
    });
  }

  // Botones para expandir/colapsar el sidebar
  const toggleButtons = document.querySelectorAll(".toggle-btn");
  toggleButtons.forEach(button => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      document.getElementById("sidebar")?.classList.toggle("expand");
    });
  });

  // Inicialización de la tabla con DataTables y sus botones
  $(document).ready(function () {
  $('#miTabla').DataTable({
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'copy',
        text: 'Copiar',
      },
      {
        extend: 'csv',
        text: 'CSV',
      },
      {
        extend: 'excel',
        text: 'Excel',
      },
      {
        extend: 'pdf',
        text: 'PDF',
      },
      {
        extend: 'print',
        text: 'Imprimir',
      }
    ],
    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    iDisplayLength: 5
  });
});

});

// Notificación de éxito si hay mensaje global de success 
if (window.mensajeSuccess) {
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Éxito',
    text: window.mensajeSuccess,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
}

// Notificación de error si hay mensaje global de error
if (window.mensajeError) {
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: 'Error',
    text: window.mensajeError,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
}
if(window.errorUsuario){
   Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Usuario o contraseña incorrectos',
        confirmButtonText: 'Aceptar'
    });
}