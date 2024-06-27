<?php
include 'config.php';

$user_id = $_GET['user_id'];

$sql = "SELECT SUM(hours_worked) AS monthly_total FROM Overtime WHERE user_id = '$user_id' AND MONTH(start_time) = MONTH(CURRENT_DATE())";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(["monthly_total" => 0]);
}

$conn->close();
?>
