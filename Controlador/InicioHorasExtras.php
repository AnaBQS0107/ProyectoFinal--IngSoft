<?php
include 'config.php';

$user_id = $_POST['user_id'];
$start_time = date('Y-m-d H:i:s');

$sql = "INSERT INTO Overtime (user_id, start_time) VALUES ('$user_id', '$start_time')";

if ($conn->query($sql) === TRUE) {
    echo "Overtime started";
} else {
    echo "Error: Conexión fallida" . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
