<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Admin Dashboard</span>
            <a href="admin_logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
        <p>Manage bookings and venues below.</p>
        <a href="\venue_locator\template\admin\manage_bookings2.php" class="btn btn-primary">Manage Bookings</a>
        <a href="list_venues.php" class="btn btn-secondary">Manage Venues</a>
    </div>
</body>
</html>