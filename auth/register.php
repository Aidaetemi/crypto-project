<?php
session_start();
require_once "config/database_connection.php";

$message = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // kontrollo a ekziston email
    $check = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Ky email tashmë ekziston.";
    } else {

        // hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // gjenero token për verifikim
        $token = bin2hex(random_bytes(50));

        // insert user
        $sql = "INSERT INTO users (username, email, password, verify_token, is_verified)
                VALUES (?, ?, ?, ?, 0)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $token);

        if ($stmt->execute()) {

            // link për verifikim email
            $verifyLink = "http://localhost/crypto/auth/email_verification.php?token=" . $token;

            $message = "Regjistrimi u krye me sukses!<br>
            Verifiko email-in këtu: <br>
            <a href='$verifyLink'>$verifyLink</a>";

        } else {
            $message = "Gabim gjatë regjistrimit.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="register">Register</button>
</form>

<p style="color:green;">
    <?php echo $message; ?>
</p>

</body>
</html>