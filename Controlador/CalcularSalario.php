<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
    
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Configurar la conexión a la base de datos
require_once '../Config/config.php'; // Asegúrate de que la conexión a la base de datos está configurada correctamente
require_once 'Controlador.php';
require_once '../Modelo/CalcularSalario.php';

//use App\Controller; // llama a la herencia controller//
//use App\Modelo\CalcularSalario;  // esto conecta con la carpeta modelo de calcular salario//


class CalcularSalarioControlador extends Controller  //herencia controller//
{
    public function index()
    {
        $user = $_SESSION['user'];
        $cedula = $user['Persona_Cedula']; // llama a persona logeada
        $conn = getConnection(); // codigo para la conexion



        $sql = "SELECT SalarioBase FROM empleados WHERE Persona_Cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$cedula]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);// Use var_dump($array) to get more information of the content in the array like the datatype and length
        $salario_base = $result['SalarioBase'] ?? 0;// respuesta base de datos//

        $modelo_salario = new CalcularSalario($cedula, $salario_base, null, null, null, null);

        $this->render('CalcularSalario', ['modelo_salario' => $modelo_salario]); //eso llamar a vista y a data del controller//

    }

     function calcularHorasTrabajadas($fechaInicio, $fechaFinal) {
        $inicio = new DateTime($fechaInicio);
        $final = new DateTime($fechaFinal);
        
        // Asegúrate de que la fecha final sea después de la fecha de inicio
        if ($final < $inicio) {
            throw new Exception("La fecha final debe ser después de la fecha de inicio.");
        }
    
        $intervalo = $inicio->diff($final);
        
        // Calcula el total de horas trabajadas
        $horas = ($intervalo->days * 8) + $intervalo->h;
        
        return $horas;
    }
    
    function calcularSalarioTotal($salarioPorHora, $horasTrabajadas) {
        return $salarioPorHora * $horasTrabajadas;


    }

    public function Calcular($modelo_salario)
    {

        $salarioPorHora = ((floatval($modelo_salario->salario_base) / 4.3) / 48);
 
        

        $horasTrabajadas = $this->calcularHorasTrabajadas($modelo_salario->fecha_inicio, $modelo_salario->fecha_final);
       // var_dump($horasTrabajadas);  prueba
        $salarioTotal = $this->calcularSalarioTotal($salarioPorHora, $horasTrabajadas);

        $modelo_salario->horas_trabajadas = $horasTrabajadas;
        $modelo_salario->salario_calculado_total = $salarioTotal;// despues de esto hacer la conexion con base de datos **** PARA GUARDARLA EN LA BASE DE DATOS

        //var_dump($modelo_salario);  prueba

        $this->render('CalcularSalario', ['modelo_salario' => $modelo_salario]); //eso llamar a vista y a data del controller//
    }


}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $controlador = new CalcularSalarioControlador();
    $controlador->index();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $salario_base = $_POST['salario_base'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $cedula = $_POST['persona_cedula'];

    //echo $salario_base.' '.$fecha_inicio.' '.$fecha_final; es un print en php

  
    $modelo_salario = new CalcularSalario($cedula, $salario_base, null, null, $fecha_inicio, $fecha_final);
    /*
    var_dump($modelo_salario);     ESTO SE USA PARA VER QUE LOS DATOS DE MODELO SALARIO ESTEN LLEGANDO DEL FORMULARIO
*/
    $controlador = new CalcularSalarioControlador();
    $controlador->Calcular($modelo_salario);

    /*
  
    $pago_extra = $salario * 1.5 * $horas;
    header("Location: ../Vista/CalculadoraExtras.php?resultado=$pago_extra");
    exit();
    */
}
/*
        // Insertar datos en la base de datos usando PDO
        $sql = "INSERT INTO liquidaciones (FechaEntrada, FechaSalida, Preaviso, MotivoSalida, TipoPago, Empleados_Persona_Cedula, VacacionesDisponibles, MontoVacaciones, MontoPreaviso, MontoCesantia, Total) 
        VALUES (:fechaEntrada, :fechaSalida, :preaviso, :motivoSalida, :tipoPago, :Persona_Cedula, :saldoVacaciones, :vacaciones, :preavisoMonto, :cesantia, :total)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fechaEntrada', $fechaEntrada);
        $stmt->bindParam(':fechaSalida', $fechaSalida);
        $stmt->bindParam(':preaviso', $preaviso);
        $stmt->bindParam(':motivoSalida', $motivoSalida);
        $stmt->bindParam(':tipoPago', $tipoPago);
        $stmt->bindParam(':Persona_Cedula', $Persona_Cedula); 
        $stmt->bindParam(':saldoVacaciones', $saldoVacaciones);
        $stmt->bindParam(':vacaciones', $vacaciones);
        $stmt->bindParam(':preavisoMonto', $preavisoMonto);
        $stmt->bindParam(':cesantia', $cesantia);
        $stmt->bindParam(':total', $total);

        // Ejecutar la consulta
        $stmt->execute();

        */