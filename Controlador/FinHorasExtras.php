<?php
include 'config.php';

$user_id = $_POST['user_id'];
$end_time = date('Y-m-d H:i:s');

$sql = "UPDATE Overtime SET end_time = '$end_time' WHERE user_id = '$user_id' AND end_time IS NULL";

if ($conn->query($sql) === TRUE) {
    $calculateHoursWorked = "UPDATE Overtime SET hours_worked = TIMESTAMPDIFF(HOUR, start_time, end_time) WHERE user_id = '$user_id' AND end_time = '$end_time'";
    if ($conn->query($calculateHoursWorked) === TRUE) {
        echo "Overtime ended and hours calculated";
    } else {
        echo "Error: Conexión fallida" . $calculateHoursWorked . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
