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
    swal({
        title: "¿Estás seguro?",
        text: "Una vez eliminado, no podrás recuperar este cobro.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.location.href = `TablaCobros.php?eliminarCobro=${idCobro}`;
        } else {
            swal("El cobro no ha sido eliminado.");
        }
    });
}

