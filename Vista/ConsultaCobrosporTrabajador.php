<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos/CobrosTrabajador.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <title>Consulta de Cobros por Trabajador</title>
</head>

<body>
<header>
    <?php include 'Header.php'; ?>
</header>
<br><br>
   <center><h1>Consulta de Cobros por Trabajador</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <label for="search">Buscar por Nombre o Cédula:</label>
        <input type="text" id="search" name="search">
        <button type="submit">Buscar</button>
    </form></center>

    <?php
    require_once '../Config/config.php';

    $database = new Database1();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $whereClause = '';

            if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                $search = $_GET['search'];
                $whereClause = "WHERE p.Nombre LIKE :search OR p.Cedula LIKE :search";
            }

            $query = "SELECT 
                        p.Cedula,
                        p.Nombre,
                        COUNT(cp.idCobrosPeaje) AS TotalCobros,
                        SUM(cp.TipoVehiculo_Tarifa) AS TotalRecaudado
                      FROM 
                        Persona p
                      LEFT JOIN CobrosPeaje cp ON p.Cedula = cp.Empleados_Persona_Cedula
                      $whereClause
                      GROUP BY 
                        p.Cedula";

            $stmt = $conn->prepare($query);

            if (!empty($whereClause)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                echo "<table>";
                echo "<tr><th>Cédula</th><th>Nombre</th><th>Total de Cobros</th><th>Total Recaudado</th></tr>";

                foreach ($resultados as $resultado) {
                    echo "<tr>";
                    echo "<td>{$resultado['Cedula']}</td>";
                    echo "<td>{$resultado['Nombre']}</td>";
                    echo "<td>{$resultado['TotalCobros']}</td>";
                    echo "<td>{$resultado['TotalRecaudado']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No se encontraron resultados.</p>";
            }

        } catch (PDOException $e) {
            echo "Error al realizar la consulta: " . $e->getMessage();
        }
    } else {
        echo "No se pudo establecer la conexión.";
    }
    ?>
<br><br>
<footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
</body>
</html>
