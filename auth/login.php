<?php
session_start();
require_once "config/database_connection.php";

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // gjej user-in
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $message = "Email ose password gabim.";
    } else {

        $user = $result->fetch_assoc();

        // kontrollo password
        if (!password_verify($password, $user['password'])) {
            $message = "Email ose password gabim.";
        }
        // kontrollo verifikimin e email-it
        else if ($user['is_verified'] == 0) {
            $message = "Duhet me verifiku email-in para login.";
        }
        else {
            // krijo session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // redirect sipas role
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>

<p style="color:red;">
    <?php echo $message; ?>
</p>

</body>
</html>