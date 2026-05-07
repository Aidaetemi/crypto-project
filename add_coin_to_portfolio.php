<?php
include("includes/check.php");
include("config/database_connection.php");

$user_id = $_SESSION['user_id'];

$coin_id = $_GET['id'];

if (isset($_POST['add_portfolio'])) {

    $amount = $_POST['amount'];

    $insert = "
    INSERT INTO portfolio(user_id,coin_id,amount)
    VALUES('$user_id','$coin_id','$amount')
    ";

    mysqli_query($conn, $insert);

    header("Location: my_portfolio.php");
}

include("includes/user_header.php");
include("includes/user_navbar.php");
?>

<div style="padding:30px;">

<h1>Add To Portfolio</h1>

<form method="POST">

<input
type="number"
step="0.0001"
name="amount"
placeholder="Amount"
required
>

<br><br>

<button name="add_portfolio">
    Add
</button>

</form>

</div>

<?php
include("includes/user_footer.php");
?>