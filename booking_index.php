<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "venue_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_POST['confirm_delete_id'])) {
    $delete_id = intval($_POST['confirm_delete_id']);
    $deleteQuery = "DELETE FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $delete_id);

    echo $stmt->execute() ? "success" : "error";
    exit;
}

// Fetch bookings with venue details
$query = "SELECT b.*, v.name AS venue_name FROM bookings b JOIN venues v ON b.venue_id = v.id ORDER BY b.event_date DESC";
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container { max-width: 1400px; }
        .table th { background: #FFC107; color: #000; text-align: center; font-weight: bold; }
        .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
        .table td { text-align: center; vertical-align: middle; }
        .id-photo { width: 40px; height: 40px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Manage Bookings</h2>
    <a href="index.php" class="btn btn-secondary mb-3">&larr; Back to Venues</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Venue</th>
                <th>Event</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Attendees</th>
                <th>Cost</th>
                <th>Payment</th>
                <th>Shared?</th>
                <th>ID Photo</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['venue_name']); ?></td>
                <td><?= htmlspecialchars($row['event_name']); ?></td>
                <td><?= htmlspecialchars($row['event_date']); ?></td>
                <td><?= htmlspecialchars($row['start_time']); ?></td>
                <td><?= htmlspecialchars($row['end_time']); ?></td>
                <td><?= htmlspecialchars($row['full_name']); ?></td>
                <td><?= htmlspecialchars($row['contact_number']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['num_attendees']); ?></td>
                <td>₱<?= number_format($row['total_cost'], 2); ?></td>
                <td><?= htmlspecialchars($row['payment_method']); ?></td>
                <td><?= $row['shared_booking'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <?php if (!empty($row['id_photo'])) { ?>
                        <a href="<?= htmlspecialchars($row['id_photo']); ?>" target="_blank">
                            <img src="<?= htmlspecialchars($row['id_photo']); ?>" class="id-photo" alt="ID Photo">
                        </a>
                    <?php } else { ?>
                        No Photo
                    <?php } ?>
                </td>
                <td><span class="badge bg-<?= ($row['status'] == 'Pending') ? 'warning' : 'danger' ?>">
                        <?= htmlspecialchars($row['status']); ?>
                    </span>
                </td>
                <td>
                <a href="edit_booking.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id']; ?>">Delete</button>
                </td>

            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    var deleteId = 0;
    $('.delete-btn').click(function() {
        deleteId = $(this).data('id');
        if (confirm("Are you sure you want to delete this booking?")) {
            $.post('manage_bookings.php', { confirm_delete_id: deleteId }, function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert('Error deleting booking.');
                }
            });
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
