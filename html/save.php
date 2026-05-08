<?php
$conn = mysqli_connect("mysql", "root", "1234", "game_db");

if (!$conn) {
    die("DB 연결 실패");
}

$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['userId'];
$time = $data['time'];

$sql = "INSERT INTO scores (userId, time) VALUES ('$userId', '$time')";
mysqli_query($conn, $sql);

echo "ok";
?>