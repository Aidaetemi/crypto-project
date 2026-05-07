<?php
include("includes/check.php");
include("../config/database_connection.php");

$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$total_coins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM coins"));

include("includes/admin_header.php");
include("includes/admin_sidebar.php");
?>

<div style="margin-left:250px;padding:20px;">

    <h1>Admin Dashboard</h1>

    <div style="display:flex;gap:20px;">

        <div style="background:#22c55e;padding:20px;color:white;border-radius:10px;">
            <h2><?php echo $total_users; ?></h2>
            <p>Total Users</p>
        </div>

        <div style="background:#3b82f6;padding:20px;color:white;border-radius:10px;">
            <h2><?php echo $total_coins; ?></h2>
            <p>Tota</p>
        </div>

    </div>

</div>

<?php
include("includes/admin_footer.php");
?>