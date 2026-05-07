<?php
include("../config/database_connection.php");
include("../config/mail_configuration.php");

$message = "";

if (isset($_POST['send_link'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {

        $token = bin2hex(random_bytes(50));

        $expire_date = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $update_token = "
        UPDATE users 
        SET reset_token='$token',
            token_expire='$expire_date'
        WHERE email='$email'
        ";

        mysqli_query($conn, $update_token);

        $reset_link = "
        http://localhost/crypto-project/auth/reset_password.php?token=$token
        ";

        $body = "
        <div style='font-family:Arial;padding:20px;background:#0f172a;color:white'>
            
            <h2>🔐 Password Reset</h2>

            <p>Kliko butonin më poshtë për me ndërru passwordin:</p>

            <a href='$reset_link'
            style='
            background:#22c55e;
            color:white;
            padding:12px 18px;
            text-decoration:none;
            border-radius:8px;
            display:inline-block;
            margin-top:15px;
            '>
            Reset Password
            </a>

            <p style='margin-top:20px;color:gray;font-size:13px'>
            Ky link skadon për 1 orë.
            </p>

        </div>
        ";

        if (sendMail($email, "Reset Password", $body)) {
            $message = "✅ Reset link u dërgua në email!";
        } else {
            $message = "❌ Email failed!";
        }

    } else {
        $message = "❌ Ky email nuk ekziston!";
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

<p><?php echo $message; ?></p>

<form method="POST">

    <input 
    type="email" 
    name="email" 
    placeholder="Enter your email"
    required
    >

    <br><br>

    <button name="send_link">
        Send Reset Link
    </button>

</form>

</body>
</html>