<?php
require_once '../Config/config.php'; // Asegúrate de que esta línea esté presente y correcta

try {
    $queryEmpleadosHorarios = "SELECT p.Cedula, r.Nombre_Rol AS Rol, e.SalarioBase, est.Nombre AS Estacion, ht.Entrada, ht.Salida
                              FROM empleados e
                              INNER JOIN persona p ON e.Persona_Cedula = p.Cedula
                              INNER JOIN roles r ON e.Roles_idRoles = r.idRoles
                              INNER JOIN EstacionesPeaje est ON e.EstacionesPeaje_idEstacionesPeaje = est.idEstacionesPeaje
                              INNER JOIN horario_trabajo ht ON e.Horario_idHorario = ht.IdHorario";

    $stmtEmpleadosHorarios = $conn->prepare($queryEmpleadosHorarios);
    $stmtEmpleadosHorarios->execute();
    $empleadosHorarios = $stmtEmpleadosHorarios->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos/HorarioTrabajador.css">
    <title>Horarios de Trabajo de los Empleados del Peaje</title>
</head>
<body>
<header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
<div class="container mt-5">
    <center><h1>Horarios de Trabajo de los Empleados del Peaje</h1></center>

    <?php if (!empty($empleadosHorarios)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cédula</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Salario Base</th>
                    <th scope="col">Estación</th>

                    <th scope="col">Hora de Entrada</th>
                    <th scope="col">Hora de Salida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleadosHorarios as $empleado): ?>
                    <tr>

                        <td><?php echo htmlspecialchars($empleado['Cedula']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Rol']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['SalarioBase']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Estacion']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Entrada']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Salida']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron empleados con horarios de trabajo asignados.
        </div>
    <?php endif; ?>
</div>
<br><br><br>
<footer>
    <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>
