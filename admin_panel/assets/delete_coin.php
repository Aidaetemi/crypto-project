<?php
include("includes/check.php");
include("../config/database_connection.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM coins WHERE id='$id'");

header("Location: manage_coins.php");
?>