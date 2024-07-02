<?php
require_once '../Config/config.php'; 

if (isset($_GET['id'])) {
    $idCobro = $_GET['id'];

    $database = new Database1();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $query = "SELECT 
                        cp.idCobrosPeaje, 
                        cp.Fecha, 
                        cp.EstacionesPeaje_idEstacionesPeaje, 
                        cp.Empleados_Persona_Cedula, 
                        cp.TipoVehiculo_idTipoVehiculo, 
                        cp.TipoVehiculo_Codigo, 
                        cp.TipoVehiculo_Tarifa 
                      FROM 
                        CobrosPeaje cp
                      WHERE 
                        cp.idCobrosPeaje = :idCobro";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idCobro', $idCobro, PDO::PARAM_INT);
            $stmt->execute();
            $cobro = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error al obtener datos: " . $e->getMessage();
        }
    } else {
        echo "No se pudo establecer la conexión.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cobro</title>
    <link rel="stylesheet" href="Estilos/EditarCobro.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>

<header>
    <?php include 'Header.php'; ?>
</header>

<body>
    <br><br><br><br><br><br><br><br>
    <div>
        <h1>Editar Cobro</h1>
        <form action="../Controlador/ActualizarCobro.php" method="POST">
            
            <input type="hidden" name="idCobrosPeaje" value="<?php echo $cobro['idCobrosPeaje']; ?>">
            <label for="Fecha">Fecha:</label>
            <input type="date" id="Fecha" name="Fecha" value="<?php echo $cobro['Fecha']; ?>">
            <label for="EstacionesPeaje_idEstacionesPeaje">Estación de Peaje:</label>
            <select id="EstacionesPeaje_idEstacionesPeaje" name="EstacionesPeaje_idEstacionesPeaje">
                <?php
              
                $queryEstaciones = "SELECT idEstacionesPeaje, Nombre FROM EstacionesPeaje";
                $stmtEstaciones = $conn->prepare($queryEstaciones);
                $stmtEstaciones->execute();
                $estaciones = $stmtEstaciones->fetchAll(PDO::FETCH_ASSOC);

                foreach ($estaciones as $estacion) {
                    $selected = ($estacion['idEstacionesPeaje'] == $cobro['EstacionesPeaje_idEstacionesPeaje']) ? 'selected' : '';
                    echo '<option value="' . $estacion['idEstacionesPeaje'] . '" ' . $selected . '>' . $estacion['Nombre'] . '</option>';
                }
                ?>
            </select>
            <label for="Empleados_Persona_Cedula">Cédula Empleado:</label>
            <input type="text" id="Empleados_Persona_Cedula" name="Empleados_Persona_Cedula" value="<?php echo $cobro['Empleados_Persona_Cedula']; ?>">
            <label for="TipoVehiculo_idTipoVehiculo">Tipo de Vehiculo:</label>
            <select id="TipoVehiculo_idTipoVehiculo" name="TipoVehiculo_idTipoVehiculo">
                <?php
          
                $queryTiposVehiculo = "SELECT idTipoVehiculo, Tipo FROM TipoVehiculo";
                $stmtTiposVehiculo = $conn->prepare($queryTiposVehiculo);
                $stmtTiposVehiculo->execute();
                $tiposVehiculo = $stmtTiposVehiculo->fetchAll(PDO::FETCH_ASSOC);

                foreach ($tiposVehiculo as $tipoVehiculo) {
                    $selected = ($tipoVehiculo['idTipoVehiculo'] == $cobro['TipoVehiculo_idTipoVehiculo']) ? 'selected' : '';
                    echo '<option value="' . $tipoVehiculo['idTipoVehiculo'] . '" ' . $selected . '>' . $tipoVehiculo['Tipo'] . '</option>';
                }
                ?>
            </select>
            <label for="TipoVehiculo_idTipoVehiculo">Tipo de Vehiculo:</label>
            <select id="TipoVehiculo_idTipoVehiculo" name="TipoVehiculo_idTipoVehiculo">
                <?php
             
                $queryTiposVehiculo = "SELECT idTipoVehiculo, Tipo, Codigo FROM TipoVehiculo";
                $stmtTiposVehiculo = $conn->prepare($queryTiposVehiculo);
                $stmtTiposVehiculo->execute();
                $tiposVehiculo = $stmtTiposVehiculo->fetchAll(PDO::FETCH_ASSOC);

                foreach ($tiposVehiculo as $tipoVehiculo) {
                    $selected = ($tipoVehiculo['idTipoVehiculo'] == $cobro['TipoVehiculo_idTipoVehiculo']) ? 'selected' : '';
                    echo '<option value="' . $tipoVehiculo['idTipoVehiculo'] . '" ' . $selected . '>' . $tipoVehiculo['Codigo'] . '</option>';
                }
                ?>
                   </select>
        
            <label for="TipoVehiculo_Tarifa">Tarifa:</label>
            <input type="text" id="TipoVehiculo_Tarifa" name="TipoVehiculo_Tarifa" value="<?php echo $cobro['TipoVehiculo_Tarifa']; ?>">
           <center> <button type="button" id="btnActualizar">Actualizar</button> </center>
        </form>
    </div>

    <footer>
    <?php include 'Footer.php'; ?>
    </footer>
    
    

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
document.getElementById('btnActualizar').addEventListener('click', function() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, actualizar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelector('form').submit();
        }
    });
});
</script>
