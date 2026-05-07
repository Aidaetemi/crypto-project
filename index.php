<?php
include(__DIR__ ."/includes/check.php");
include(__DIR__ . "/config/database_connection.php");

$total_coins = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM coins")
);

include(__DIR__ . "/includes/user_header.php");
include(__DIR__ . "/includes/user_navbar.php");
?>
<div style="padding:30px;">

    <h1>Welcome User 👋</h1>

    <div style="
    background:#22c55e;
    width:250px;
    padding:20px;
    border-radius:10px;
    color:white;
    ">

        <h2><?php echo $total_coins; ?></h2>

        <p>Total Available Coins</p>

    </div>

</div>

<?php
include(__DIR__ . "/includes/user_footer.php");
?>
