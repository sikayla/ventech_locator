<?php  
session_start();
$conn = new mysqli("localhost", "root", "", "venue_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings with venue details
$query = "SELECT b.*, v.name AS venue_name  
          FROM bookings b
          JOIN venues v ON b.venue_id = v.id
          ORDER BY b.id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Admin - Manage Bookings</h2>
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
                    <tr>
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
                            <span class="badge bg-<?= ($row['status'] == 'Approved') ? 'success' : (($row['status'] == 'Rejected') ? 'danger' : 'warning') ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                            $photoFile = htmlspecialchars($row['id_photo']); // Get file name
                            $photoPath = "../uploads/" . basename($photoFile); // Adjust path to where images are stored
                            
                            if (!empty($photoFile) && file_exists($photoPath)) { ?>
                                <a href="<?= $photoPath ?>" target="_blank">
                                    <img src="<?= $photoPath ?>" alt="ID Photo" width="40">
                                </a>
                            <?php } else { ?>
                                <span class='text-danger'>No Image</span>
                                <br><small class="text-muted"><?= $photoPath ?></small> <!-- Debugging: Show path -->
                            <?php } ?>
                        </td>

                        <td>
                            <button class="btn btn-success update-status" data-id="<?= $row['id'] ?>" data-status="Approved">Approve</button>
                            <button class="btn btn-danger update-status" data-id="<?= $row['id'] ?>" data-status="Rejected">Reject</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $(".update-status").click(function() {
                let bookingId = $(this).data("id");
                let status = $(this).data("status");

                $.ajax({
                    url: "update_status.php",
                    type: "POST",
                    data: { booking_id: bookingId, action: status },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $("#status-" + bookingId).html(
                                `<span class="badge bg-${status === "Approved" ? "success" : "danger"}">${status}</span>`
                            );
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



