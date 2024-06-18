<?php

require_once '../Controlador/Cobro.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cobros</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaCobros.css">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
    <div class="container mt-5">
        <br><br><br><br>
        <center><h1>Lista de Cobros</h1></center>
        <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tipo de vehiculo</th>
                    <th scope="col">Código</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Persona que tramita</th>
                    <th scope="col">Estación</th>
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($cobros as $cobro): ?>
                    <tr>
                        <td><?php echo $cobro['Tipo_De_Vehiculo']; ?></td>
                        <td><?php echo $cobro['Codigo']; ?></td>
                        <td><?php echo $cobro['Monto']; ?></td>
                        <td><?php echo $cobro['Tramitador']; ?></td>
                        <td><?php echo $cobro['Estacion']; ?></td>
                        <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Eliminar</button>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br>
        <div class="div_btn">
        <center> <button type="submit" class="btn_asignar">Asignar un nuevo cobro</button></center>
    </div>
    <br>
    <div class="div_btn">
        <center> <button type="submit" class="btn_registrar">Exportar PDF</button></center>
    </div>
    </div>

</body>

</html>