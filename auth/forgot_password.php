<?php
session_start();
require_once "config/database_connection.php";

$message = "";

if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);

    // kontrollo a ekziston useri
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $message = "Ky email nuk ekziston në sistem.";
    } else {

        // gjenero token
        $token = bin2hex(random_bytes(50));
        $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // ruaje në DB
        $update = "UPDATE users SET reset_token = ?, token_expire = ? WHERE email = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("sss", $token, $expire, $email);
        $stmt->execute();

        // link për reset
        $resetLink = "http://localhost/crypto/auth/reset_password.php?token=" . $token;

        // MESAZH (këtu më vonë mund ta dërgosh me PHPMailer)
        $message = "Linku për reset password: <br><a href='$resetLink'>$resetLink</a>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>

<h2>Forgot Password</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Shkruaj email-in" required>
    <button type="submit" name="submit">Dërgo link</button>
</form>

<p style="color:blue;">
    <?php echo $message; ?>
</p>

</body>
</html>