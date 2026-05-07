<?php
include("includes/check.php");
include("../config/database_connection.php");

$id = $_GET['id'];

$coin = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM coins WHERE id='$id'")
);

if (isset($_POST['update_coin'])) {

    $name = $_POST['coin_name'];
    $symbol = $_POST['coin_symbol'];
    $price = $_POST['coin_price'];

    mysqli_query($conn, "
    UPDATE coins
    SET
    name='$name',
    symbol='$symbol',
    price='$price'
    WHERE id='$id'
    ");

    header("Location: manage_coins.php");
}

include("includes/admin_header.php");
include("includes/admin_sidebar.php");
?>

<div style="margin-left:250px;padding:20px;">

    <h1>Edit Coin</h1>

    <form method="POST">

        <input type="text"
        name="coin_name"
        value="<?php echo $coin['name']; ?>">
        <br><br>

        <input type="text"
        name="coin_symbol"
        value="<?php echo $coin['symbol']; ?>">
        <br><br>

        <input type="number"
        step="0.01"
        name="coin_price"
        value="<?php echo $coin['price']; ?>">
        <br><br>

        <button name="update_coin">
            Update Coin
        </button>

    </form>

</div>

<?php
include("includes/admin_footer.php");
?>