<?php
session_start();
require_once "config/database_connection.php";

$message = "";

// merr token nga URL
if (!isset($_GET['token'])) {
    die("Token mungon.");
}

$token = $_GET['token'];

// kontrollo token në DB
$sql = "SELECT * FROM users WHERE reset_token = ? AND token_expire > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Token i pavlefshëm ose i skaduar.");
}

$user = $result->fetch_assoc();

// kur useri submit-on password-in e ri
if (isset($_POST['reset'])) {

    $newPassword = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        $message = "Password-at nuk përputhen.";
    } else {

        // hash password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // update password + fshij token
        $update = "UPDATE users 
                   SET password = ?, reset_token = NULL, token_expire = NULL 
                   WHERE id = ?";

        $stmt = $conn->prepare($update);
        $stmt->bind_param("si", $hashedPassword, $user['id']);

        if ($stmt->execute()) {
            $message = "Password u ndryshua me sukses! <a href='../login.php'>Login</a>";
        } else {
            $message = "Gabim gjatë ndryshimit të password-it.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>

<h2>Reset Password</h2>

<form method="POST">
    <input type="password" name="password" placeholder="New Password" required><br><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
    <button type="submit" name="reset">Reset Password</button>
</form>

<p style="color:green;">
    <?php echo $message; ?>
</p>

</body>
</html>