document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-delete').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const employeeCedula = this.getAttribute('data-Cedula');

            swal({
                title: "¿Seguro que deseas borrar este usuario?",
                text: "Una vez eliminado no podrás recuperarlo",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    fetch(`../Controlador/EliminarEmpleado.php?Cedula=${employeeCedula}`, {
                            method: 'GET'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('No se pudo completar la solicitud de eliminación');
                            }
                            return response.text();
                        })
                        .then(data => {
                            if (data.trim() === 'success') {
                                swal("Usuario eliminado con éxito", {
                                    icon: "success",
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                swal("No se pudo eliminar este usuario", {
                                    icon: "error",
                                });
                            }
                        })
                        .catch(error => {
                            swal("Error al intentar eliminar el usuario", {
                                icon: "error",
                            });
                            console.error('Error:', error.message); // Loguear el error en la consola para depuración
                        });
                } else {
                    swal("El usuario permanecerá en la base de datos");
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const searchButton = document.getElementById('searchButton');
    const searchInput = document.getElementById('searchInput');
    
    searchButton.addEventListener('click', () => {
        const filter = searchInput.value.toUpperCase();
        const rows = document.querySelector("table tbody").rows;
        
        for (let i = 0; i < rows.length; i++) {
            let shouldShow = false;
            const cells = rows[i].cells;
            
            for (let j = 0; j < cells.length - 1; j++) { // -1 to exclude last "Acciones" column
                const cellText = cells[j].textContent.toUpperCase();
                if (cellText.indexOf(filter) > -1) {
                    shouldShow = true;
                    break;
                }
            }
            
            rows[i].style.display = shouldShow ? "" : "none";
        }
    });
});

