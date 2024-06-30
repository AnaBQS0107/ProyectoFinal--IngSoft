
<?php
//
//
//Borrar este archivo si lo de Horas extras funciona!!!! Esto era solo la calculadora

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $salario = $_POST['salario'];
    $horas = $_POST['horas'];
    $pago_extra = $salario * 1.5 * $horas;
    header("Location: ../Vista/CalculadoraExtras.php?resultado=$pago_extra");
    exit();
}
?>