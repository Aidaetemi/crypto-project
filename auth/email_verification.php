<?php
session_start();
require_once "config/database_connection.php"; // lidhja me database

if (!isset($_GET['token'])) {
    die("Token nuk është valid.");
}

$token = $_GET['token'];

// kërko user-in me token
$sql = "SELECT * FROM users WHERE verify_token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Token i pavlefshëm ose i skaduar.");
}

$user = $result->fetch_assoc();

// përditëso user-in si të verifikuar
$update = "UPDATE users SET is_verified = 1, verify_token = NULL WHERE id = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("i", $user['id']);

if ($stmt->execute()) {
    echo "<h2>Email u verifikua me sukses!</h2>";
    echo "<a href='../login.php'>Hyr në llogari</a>";
} else {
    echo "Gabim gjatë verifikimit.";
}
?>