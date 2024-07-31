<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['Empleados_Persona_Cedula'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];
   
    return mysql.connector.connect(
        $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "servicio_autobuses";
    
 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $horas = $_POST['horas'];
        $tasa = $_POST['tasa'];

        // Validar los datos
        if (is_numeric($horas) && is_numeric($tasa)) {
            // Calcular el salario
            $salario = $horas * $tasa;
            echo "<p>Horas trabajadas: $horas</p>";
            echo "<p>Tasa por hora: $$tasa</p>";
            echo "<h2>Salario Total: $$salario</h2>";
        } else {
            echo "<p>Por favor, ingrese valores numéricos válidos.</p>";
        }
    } else {
        echo "<p>Por favor, complete el formulario primero.</p>";
    }
    ?>
    <br>
    <a href="index.html">Volver al formulario</a>
</body>