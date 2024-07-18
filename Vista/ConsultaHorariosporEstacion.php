<?php
require_once '../Config/config.php'; 

try {
    $queryEstaciones = "SELECT idEstacionesPeaje, Nombre FROM EstacionesPeaje ORDER BY Nombre";
    $stmtEstaciones = $conn->prepare($queryEstaciones);
    $stmtEstaciones->execute();
    $estaciones = $stmtEstaciones->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
} catch(Exception $e) {
    echo "Error general: " . $e->getMessage();
}

$horarios = []; 

try {
    // Consulta para obtener todos los horarios sin filtro de estación
    $queryHorarios = "SELECT Entrada, Salida FROM horario_trabajo ORDER BY Entrada";
    $stmtHorarios = $conn->prepare($queryHorarios);
    $stmtHorarios->execute();
    $horarios = $stmtHorarios->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error al obtener los horarios: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <center><title>Mostrar Horarios por Estación</title></center>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Horarioestacion.css">
</head>
<body>
<header>
    <?php include 'Header.php'; ?>
</header>
<br><br><br><br><br><br>
<div class="container mt-5">
    <h1>Mostrar Horarios por Estación</h1>
<br><br>
    <!-- Formulario para seleccionar una estación -->
    <form id="formEstacion" method="post">
        <div class="form-group">
            <select class="form-control" id="estacion" name="estacion">
                <option value="">Seleccione una estación...</option>
                <?php foreach ($estaciones as $estacion): ?>
                    <option value="<?php echo $estacion['idEstacionesPeaje']; ?>"><?php echo htmlspecialchars($estacion['Nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <center><button type="submit" class="btn btn-primary">Mostrar Horarios</button></center>
    </form>
    <!-- Tabla de Horarios -->
    <div id="tablaHorarios">
        <?php if (!empty($horarios)): ?>
            <h3>Horarios Disponibles:</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Entrada</th>
                        <th scope="col">Salida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios as $horario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($horario['Entrada']); ?></td>
                            <td><?php echo htmlspecialchars($horario['Salida']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No se encontraron horarios disponibles.
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Script para mostrar la tabla de horarios al enviar el formulario
    document.getElementById('formEstacion').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío del formulario por defecto

        // Mostrar la tabla de horarios
        document.getElementById('tablaHorarios').style.display = 'block';
    });
</script>

</body>
</html>
<footer>
    <?php include 'Footer.php'; ?>
</footer>