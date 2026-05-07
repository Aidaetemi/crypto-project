<?php
include("includes/check.php");
include("../config/database_connection.php");

$users = mysqli_query($conn, "SELECT * FROM users");

include("includes/admin_header.php");
include("includes/admin_sidebar.php");
?>

<div style="margin-left:250px;padding:20px;">

<h1>Manage Users</h1>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
</tr>

<?php while($user = mysqli_fetch_assoc($users)) { ?>

<tr>

<td><?php echo $user['id']; ?></td>
<td><?php echo $user['username']; ?></td>
<td><?php echo $user['email']; ?></td>
<td><?php echo $user['role']; ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php
include("includes/admin_footer.php");
?>