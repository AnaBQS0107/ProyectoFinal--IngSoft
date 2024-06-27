<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $salario = $_POST['salario'];
    $horas = $_POST['horas'];
    $pago_extra = $salario * 1.5 * $horas;
    header("Location: ../Vista/CalculadoraExtras.php?resultado=$pago_extra");
    exit();
}
?>