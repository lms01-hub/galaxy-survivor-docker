<?php
include "db.php";

$sql = "SELECT * FROM scores ORDER BY time DESC LIMIT 50";
$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>