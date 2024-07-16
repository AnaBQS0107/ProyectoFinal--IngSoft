<?php
include '../Config/config.php'; 

$conn = getConnection(); 

$sql = "SELECT Codigo, Tipo, Tarifa FROM TipoVehiculo";
$stmt = $conn->prepare($sql);
$stmt->execute();

$tiposVehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json'); 
echo json_encode($tiposVehiculos);

$conn = null; 
?>