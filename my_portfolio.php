<?php
include("includes/check.php");
include("config/database_connection.php");

$user_id = $_SESSION['user_id'];

$query = "
SELECT portfolio.amount,
coins.name,
coins.symbol,
coins.price

FROM portfolio

JOIN coins
ON portfolio.coin_id = coins.id

WHERE portfolio.user_id = '$user_id'
";

$portfolio = mysqli_query($conn, $query);

$total_value = 0;

include("includes/user_header.php");
include("includes/user_navbar.php");
?>

<div style="padding:30px;">

<h1>My Portfolio</h1>

<table border="1" cellpadding="10" width="100%">

<tr>
<th>Coin</th>
<th>Symbol</th>
<th>Amount</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php while($row = mysqli_fetch_assoc($portfolio)) {

$total = $row['amount'] * $row['price'];

$total_value += $total;
?>

<tr>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['symbol']; ?></td>

<td><?php echo $row['amount']; ?></td>

<td>$<?php echo $row['price']; ?></td>

<td>$<?php echo number_format($total,2); ?></td>

</tr>

<?php } ?>

</table>

<br>

<h2>
Total Portfolio Value:
$<?php echo number_format($total_value,2); ?>
</h2>

</div>

<?php
include("includes/user_footer.php");
?>
