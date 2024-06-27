function confirmDelete(idTipoVehiculo) {
    swal({
        title: "¿Estás seguro?",
        text: "Una vez eliminado, no podrás recuperar este tipo de vehículo.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.location.href = "../Controlador/EliminarVehiculo.php?idTipoVehiculo=" + idTipoVehiculo;
        } else {
            swal("Tu tipo de vehículo está seguro.");
        }
    });
}
