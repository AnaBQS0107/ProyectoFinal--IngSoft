<?php
require_once '../Controlador/Cobro.php';

$cobroController = new Cobro();
$cobros = $cobroController->getAllCobros();

if (isset($_GET['eliminarCobro'])) {
    $idCobro = $_GET['eliminarCobro'];
    $result = $cobroController->eliminarCobro($idCobro);
    if ($result === true) {
        echo 'success';
    } else {
        echo $result;
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cobros</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaCobros.css">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
    <div class="container mt-5">
        <br><br>
        <center>
            <h1>Lista de Cobros</h1>
        </center>
        <br>
        <center>
        <div class="search-container">
    <input type="text" id="searchInput" placeholder="Buscar empleado...">
    <button type="button" id="searchButton">Buscar</button></center>
</div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID Cobro</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">ID Estación</th>
                        <th scope="col">Cédula Empleado</th>
                        <th scope="col">Tipo de Vehiculo</th>
                        <th scope="col">Código</th>
                        <th scope="col">Tarifa</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cobros as $cobro): ?>
                    <tr>
                        <td><?php echo $cobro['idCobrosPeaje']; ?></td>
                        <td><?php echo $cobro['Fecha']; ?></td>
                        <td><?php echo $cobro['EstacionPeaje']; ?></td>
                        <td><?php echo $cobro['Empleados_Persona_Cedula']; ?></td>
                        <td><?php echo $cobro['TipoVehiculo']; ?></td>
                        <td><?php echo $cobro['TipoVehiculo_Codigo']; ?></td>
                        <td><?php echo $cobro['TipoVehiculo_Tarifa']; ?></td>
                        <td class="actions">
                        <a href="EditarCobro.php?id=<?php echo $cobro['idCobrosPeaje']; ?>" class="btn-edit" style="text-decoration: none; color: white;">Editar</a>
                            <button class="btn-delete" onclick="confirmarEliminar(<?php echo $cobro['idCobrosPeaje']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br><br>
            <div class="div_btn">
            </div>

            <br>
            <div class="div_btn">
                <center> <button type="submit" class="btn_registrar" onclick="location.href='../Vista/CobrosPeaje.php'">Agregar nuevo cobro</button></center>
            </div>
        </div>
    </div>
    <br><br><br>
    <script src="../JS/CobrosCRUD.js">
        
    </script>
    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
</body>

</html>