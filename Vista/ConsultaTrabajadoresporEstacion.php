<?php
require_once '../Modelo/Ingreso_Usuario.php';

$trabajadoresTabla = new TrabajadoresTabla();
$trabajadores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estacionID = isset($_POST['estacion_id']) ? intval($_POST['estacion_id']) : 0;
    if ($estacionID > 0) {
        $trabajadores = $trabajadoresTabla->obtenerTrabajadoresPorEstacion($estacionID);
    }
}

$resultEstaciones = $trabajadoresTabla->obtenerEstaciones();
?>


<?php include_once 'header.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TrabajadoresporEstacion.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <br><br>
    <center><title>Buscar Trabajadores por Estación</title>
</head>
<body>
    <h1>Buscar Trabajadores por Estación de Peaje</h1>
    <form method="post" action="">
        <br><br>
        <label for="estacion_id">Estación de Peaje:</label>
        <select id="estacion_id" name="estacion_id" required>
            <option value="">Seleccione una estación</option>
            <?php if ($resultEstaciones && count($resultEstaciones) > 0) : ?>
                <?php foreach ($resultEstaciones as $estacion) : ?>
                    <option value="<?php echo $estacion['idEstacionesPeaje']; ?>">
                        <?php echo htmlspecialchars($estacion['Nombre']); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($trabajadores) > 0): ?>
 
        <h2>Trabajadores asignados a la estación seleccionada:</h2>
    
        <table>
            <thead>
                <tr>
                   <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Fecha de Ingreso</th>
                    <th>Rol</th>
                    <th>Estación</th>
                    <th>Correo Electrónico</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trabajadores as $trabajador): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($trabajador['Cedula']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['Apellido1']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['Apellido2']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['Fecha_Ingreso']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['Nombre_Rol']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['Nombre_Estacion']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['Correo_Electronico']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No hay trabajadores asignados a esta estación de peaje.</p>
    <?php endif; ?></center>
</body>
<?php include_once 'footer.php'?>

</html>
