<?php
require 'dbconnection.php';

$sql = "SELECT * FROM tbl_services";
$result = $conn->query($sql);

$services = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = array(
            'service_id' => $row['service_id'],
            'service_name' => $row['service_name'],
            'service_description' => $row['service_description'],
            'service_price' => $row['service_price']
        );
    }
}

echo json_encode($services);

$conn->close();
?>

