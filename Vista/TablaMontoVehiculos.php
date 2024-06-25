<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Controlador/ObtenerMontosPeaje.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Tipos de Vehículo</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaEmpleados.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br><br>
    <center>
        <h1> Tipos de Vehículo </h1>
    </center>
    <br>
    <center>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar tipo de vehículo...">
            <button type="button" id="searchButton">Buscar</button>
        </div>
    </center>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id Tipo Vehículo</th>
                    <th scope="col">Código</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Tarifa</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tiposVehiculo as $tipo) : ?>
                    <tr>
                        <td><?php echo $tipo['idTipoVehiculo']; ?></td>
                        <td><?php echo $tipo['Codigo']; ?></td>
                        <td><?php echo $tipo['Tipo']; ?></td>
                        <td><?php echo $tipo['Tarifa']; ?></td>
                        <td class="actions">
                            <button class="btn-edit">Editar</button>
                            <button class="btn-delete">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($tiposVehiculo)) : ?>
                    <tr>
                        <td colspan="5">No hay tipos de vehículo disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><br>
        <div class="div_btn">
            <center>
                <!-- Enlace para agregar un nuevo tipo de vehículo, ajusta según sea necesario -->
                <button type="button" class="btn_asignar" onclick="location.href='../Vista/AgregarTipoVehiculo.php'">Agregar un nuevo tipo de vehículo</button>
            </center>
        </div>
        <br>
    </div>

    <script src="../JS/EmpleadosCRUD.js"></script>
    <?php include 'Footer.php'; ?>
</body>

</html>
