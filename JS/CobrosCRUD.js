document.addEventListener('DOMContentLoaded', () => {
    const searchButton = document.getElementById('searchButton');
    const searchInput = document.getElementById('searchInput');
    
    searchButton.addEventListener('click', () => {
        const filter = searchInput.value.toUpperCase();
        const rows = document.querySelector("table tbody").rows;
        
        for (let i = 0; i < rows.length; i++) {
            let shouldShow = false;
            const cells = rows[i].cells;
            
            for (let j = 0; j < cells.length - 1; j++) { 
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


function confirmarEliminar(idCobro) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Una vez eliminado, no podrás recuperar este cobro.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`TablaCobros.php?eliminarCobro=${idCobro}`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    Swal.fire(
                        'Eliminado!',
                        'El cobro ha sido eliminado exitosamente.',
                        'success'
                    ).then(() => {
                        window.location.href = 'TablaCobros.php';
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        `No se pudo eliminar el cobro: ${data}`,
                        'error'
                    );
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error!',
                    'Error al intentar eliminar el cobro.',
                    'error'
                );
                console.error('Error:', error.message);
            });
        } else {
            Swal.fire(
                'Cancelado',
                'El cobro no ha sido eliminado.',
                'info'
            );
        }
    });
}
