<?php
include("includes/check.php");
include("../config/database_connection.php");

$message = "";

if (isset($_POST['add_coin'])) {

    $name = $_POST['coin_name'];
    $symbol = $_POST['coin_symbol'];
    $price = $_POST['coin_price'];

    $insert = "
    INSERT INTO coins(name,symbol,price)
    VALUES('$name','$symbol','$price')
    ";

    if (mysqli_query($conn, $insert)) {
        $message = "✅ Coin added successfully!";
    } else {
        $message = "❌ Error!";
    }
}

include("includes/admin_header.php");
include("includes/admin_sidebar.php");
?>

<div style="margin-left:250px;padding:20px;">

    <h1>Add New Coin</h1>

    <p><?php echo $message; ?></p>

    <form method="POST">

        <input type="text" name="coin_name" placeholder="Coin Name" required>
        <br><br>

        <input type="text" name="coin_symbol" placeholder="Coin Symbol" required>
        <br><br>

        <input type="number" step="0.01" name="coin_price" placeholder="Coin Price" required>
        <br><br>

        <button name="add_coin">
            Add Coin
        </button>

    </form>

</div>

<?php
include("includes/admin_footer.php");
?>