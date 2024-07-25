<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "servicio_autobuses";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$sql = "SELECT * FROM vacaciones WHERE Estado = 'pendiente'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <center><title>Panel de Aprobación de Vacaciones</title></center>
    <link rel="stylesheet" href="Estilos/PanelAprobacion.css">
    <link rel="stylesheet" href="Estilos/AprobacionHorasExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    function aprobar(idVacaciones) {
        $.ajax({
            url: '../Controlador/AprobarVacaciones.php',
            type: 'POST',
            data: {
                idVacaciones: idVacaciones,
                accion: 'aprobar'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Aprobado!',
                        text: response.message
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: response.message
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error del servidor',
                    text: 'Hubo un problema al procesar tu solicitud: ' + errorThrown
                });
            }
        });
    }

    function denegar(idVacaciones) {
        $.ajax({
            url: '../Controlador/AprobarVacaciones.php',
            type: 'POST',
            data: {
                idVacaciones: idVacaciones,
                accion: 'denegar'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Denegado!',
                        text: response.message
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: response.message
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error del servidor',
                    text: 'Hubo un problema al procesar tu solicitud: ' + errorThrown
                });
            }
        });
    }
    </script>
</head>
<body>
        <header>
            <?php include 'header.php'; ?>
        </header>
<br><br>

        <div class="container-AprobacionHorasExtras">
        <center><h1>Panel de Aprobación de Vacaciones</h1></center>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Empleado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['idVacaciones']; ?></td>
                    <td><?php echo $row['Fecha_Inicio']; ?></td>
                    <td><?php echo $row['Fecha_Fin']; ?></td>
                    <td><?php echo $row['Empleados_Persona_Cedula']; ?></td>
                    <td>
                        <button class="approve-extra" onclick="aprobar(<?php echo $row['idVacaciones']; ?>)">Aprobar</button>
                        <button class="reject-extra" onclick="denegar(<?php echo $row['idVacaciones']; ?>)">Denegar</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>


    <footer id="footer"></footer>
    <?php $conn->close(); ?>
</body>
</html>