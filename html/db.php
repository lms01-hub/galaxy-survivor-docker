<?php
$conn = new mysqli("mysql", "root", "root", "game_db");

if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}
?>