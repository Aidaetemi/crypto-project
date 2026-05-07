<?php
include("../config/database_connection.php");

$message = "";

if (!isset($_GET['token'])) {
    die("❌ Invalid token!");
}

$token = $_GET['token'];

$check_token = "
SELECT * FROM users 
WHERE reset_token='$token'
AND token_expire > NOW()
";

$result = mysqli_query($conn, $check_token);

if (mysqli_num_rows($result) == 0) {
    die("❌ Token invalid ose ka skadu!");
}

if (isset($_POST['reset_password'])) {

    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $update_password = "
    UPDATE users
    SET password='$new_password',
        reset_token=NULL,
        token_expire=NULL
    WHERE reset_token='$token'
    ";

    if (mysqli_query($conn, $update_password)) {

        $message = "✅ Password u ndryshua me sukses!";

    } else {

        $message = "❌ Error!";
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

<p><?php echo $message; ?></p>

<form method="POST">

    <input 
    type="password" 
    name="new_password"
    placeholder="New Password"
    required
    >

    <br><br>

    <button name="reset_password">
        Reset Password
    </button>

</form>

</body>
</html>