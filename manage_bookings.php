<?php   
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "venue_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings with venue details
$query = "SELECT b.*, v.name AS venue_name  
          FROM bookings b
          JOIN venues v ON b.venue_id = v.id
          ORDER BY b.id DESC";
$result = $conn->query($query);

// Check for query errors
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
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Bookings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Venue</th>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Attendees</th>
                    <th>Total Cost</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>ID Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr id="booking-<?= $row['id'] ?>">
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['event_name']) ?></td>
                        <td><?= $row['event_date'] ?></td>
                        <td><?= isset($row['start_time']) ? date("h:i A", strtotime($row['start_time'])) : 'N/A' ?></td>
                        <td><?= isset($row['end_time']) ? date("h:i A", strtotime($row['end_time'])) : 'N/A' ?></td>
                        <td><?= htmlspecialchars($row['venue_name']) ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= $row['contact_number'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['num_attendees'] ?></td>
                        <td>₱<?= number_format($row['total_cost'], 2) ?></td>
                        <td><?= $row['payment_method'] ?></td>
                        <td id="status-<?= $row['id'] ?>">
                            <?php
                            if ($row['status'] == 'Approved') {
                                echo "<span class='badge bg-success'>Approved</span>";
                            } elseif ($row['status'] == 'Rejected') {
                                echo "<span class='badge bg-danger'>Rejected</span>";
                            } elseif ($row['status'] == 'Canceled') {
                                echo "<span class='badge bg-secondary'>Canceled</span>";
                            } else {
                                echo "<span class='badge bg-warning'>Pending</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            $photoFile = htmlspecialchars($row['id_photo']);
                            $photoPath = "uploads/" . basename($photoFile);

                            if (!empty($photoFile) && file_exists($photoPath)) { ?>
                                <a href="<?= $photoPath ?>" target="_blank">
                                    <img src="<?= $photoPath ?>" alt="ID Photo" width="40">
                                </a>
                            <?php } else { ?>
                                <span class='text-danger'>No Image</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="edit_booking.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm cancel-booking" data-id="<?= $row['id'] ?>">Cancel</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $(".cancel-booking").click(function() {
                let bookingId = $(this).data("id");

                if (!confirm("Are you sure you want to cancel this booking?")) return;

                $.ajax({
                    url: "cancel_booking.php",
                    type: "POST",
                    data: { booking_id: bookingId },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $("#status-" + bookingId).html("<span class='badge bg-secondary'>Canceled</span>");
                            alert("Booking has been canceled.");
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>




