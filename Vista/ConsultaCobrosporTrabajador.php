<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <br><br><br><br><br><br><br>
    <title>Consulta de Cobros por Trabajador</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<header>
    <?php include 'Header.php'; ?>
</header>
<body>
    
   <center><h1>Consulta de Cobros por Trabajador</h1>
<br>
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

            // Verificar si se ha enviado una búsqueda
            if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                $search = $_GET['search'];
                $whereClause = "WHERE p.Nombre LIKE :search OR p.Cedula LIKE :search";
            }

            // Consulta SQL para obtener todos los trabajadores y sus totales de cobros y recaudación
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

            // Bind de parámetros si se ha enviado una búsqueda
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

<footer>
    <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>
