document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector('form[action="../Modelo/Ingresar_Rol.php"]');
    
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: data.message,
                }).then(function() {
                    window.location.href = "../Vista/TablaRoles.php"; // Redirigir a la página principal o a donde desees
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: data.message,
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                title: "¡Error!",
                text: "Hubo un problema al procesar la solicitud",
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            const idRol = this.parentElement.parentElement.querySelector('td:first-child').textContent.trim();

            swal({
                title: "¿Seguro que deseas borrar este rol?",
                text: "Una vez eliminado no podrás recuperarlo",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    fetch(`../Controlador/EliminarRoles.php?idRoles=${idRol}`, {
                            method: 'GET'
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === 'success') {
                                swal("Rol eliminado con éxito", {
                                    icon: "success",
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                swal("No se pudo eliminar este rol", {
                                    icon: "error",
                                });
                            }
                        })
                        .catch(error => {
                            swal("Error al intentar eliminar el rol", {
                                icon: "error",
                            });
                        });
                } else {
                    swal("El rol permanecerá en la base de datos");
                }
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const idRol = this.getAttribute('data-idRol');

            Swal.fire({
                title: 'Editar Rol',
                input: 'text',
                inputValue: '', // Puedes predefinir el valor actual del rol aquí
                inputPlaceholder: 'Nuevo nombre del rol',
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debes ingresar un nombre para el rol';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const nuevoNombreRol = result.value;

                    // Envía la solicitud al servidor para actualizar el rol
                    fetch(`../Controlador/EditarRol.php?idRol=${idRol}&nuevoNombre=${nuevoNombreRol}`)
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === 'success') {
                                Swal.fire('¡Rol actualizado!', '', 'success').then(() => {
                                    // Recargar la página o actualizar la lista de roles
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error al actualizar el rol', '', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error al actualizar el rol', '', 'error');
                        });
                }
            });
        });
    });
});
