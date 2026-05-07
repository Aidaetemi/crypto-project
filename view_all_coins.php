<?php
include("includes/check.php");
include("config/database_connection.php");

$coins = mysqli_query($conn, "SELECT * FROM coins");

include("includes/user_header.php");
include("includes/user_navbar.php");
?>

<div style="padding:30px;">

<h1>All Coins</h1>

<table border="1" cellpadding="10" width="100%">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Symbol</th>
    <th>Price</th>
    <th>Action</th>
</tr>

<?php while($coin = mysqli_fetch_assoc($coins)) { ?>

<tr>

<td><?php echo $coin['id']; ?></td>

<td><?php echo $coin['name']; ?></td>

<td><?php echo $coin['symbol']; ?></td>

<td>$<?php echo $coin['price']; ?></td>

<td>

<a href="add_coin_to_portfolio.php?id=<?php echo $coin['id']; ?>">
    Add To Portfolio
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php
include("includes/user_footer.php");
?>
