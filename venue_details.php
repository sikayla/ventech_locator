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

// Get venue details
$venue_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM venues WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $venue_id);
$stmt->execute();
$result = $stmt->get_result();
$venue = $result->fetch_assoc();

if (!$venue) {
    echo "<script>alert('Venue not found!'); window.location.href='list_venues.php';</script>";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $num_attendees = $_POST['num_attendees'];
    $total_cost = $venue['price'];
    $payment_method = $_POST['payment_method'];
    $shared_booking = isset($_POST['shared_booking']) ? 1 : 0;

    // Upload ID Photo
    $id_photo = "";
    if (!empty($_FILES['id_photo']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name = time() . "_" . basename($_FILES["id_photo"]["name"]);
        $id_photo = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($id_photo, PATHINFO_EXTENSION));

        // Check file type
        if (in_array($imageFileType, ["jpg", "jpeg", "png"])) {
            if (!move_uploaded_file($_FILES["id_photo"]["tmp_name"], $id_photo)) {
                echo "Error uploading ID Photo.";
                exit;
            }
        } else {
            echo "Only JPG, JPEG, and PNG files are allowed.";
            exit;
        }
    }

    // Insert Booking
    $insertQuery = "INSERT INTO bookings 
        (venue_id, event_name, event_date, start_time, end_time, full_name, contact_number, email, num_attendees, total_cost, payment_method, shared_booking, id_photo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insertQuery);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("issssssssdsss", $venue_id, $event_name, $event_date, $start_time, $end_time, 
        $full_name, $contact_number, $email, $num_attendees, 
        $total_cost, $payment_method, $shared_booking, $id_photo);
    
        if ($stmt->execute()) {
            echo "<script>
                alert('Booking Successful!');
                window.open('manage_bookings2.php', '_blank');
                window.location.href = 'manage_bookings.php';
            </script>";
            exit();
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($venue['name']); ?> - Venue Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .container { max-width: 1200px; }
        .form-container {
            padding: 20px;
            border-radius: 10px;
            position: absolute;
            background:rgb(214, 214, 208);
        }
        .venue-details img { width: 100%; height: auto; border-radius: 10px; }
        .section-header { background: #FFD700; padding: 10px; font-weight: bold; border-radius: 5px; }
        .container-flex {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .booking-form {
            flex: 1;
        }
        .venue-image {
            flex: 1;
            text-align: center;
        }
        .venue-image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        @media (min-width: 768px) {
            .col-md-7 {
                flex: 0 0 auto;
                width: 50%;
                margin-left: 45%;
                margin-top: -2%;
            }
        }
        @media (min-width: 1200px) {
            .h2, h2 {
                font-size: 2rem;
                margin-left: 20px;
            }
        }
        p {
            margin-top: 0;
            margin-bottom: 1rem;
            margin-left: 20px;
        }
        .mt-5{
            margin-left: 45%;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <a href="list_venues.php" class="btn btn-secondary">← Back to Venues</a>
    <div class="row mt-3">
        <!-- Booking Form -->
        <div class="col-md-6">
            <div class="form-container">
                <h4 class="mb-3">Event Booking Form</h4>
                <form method="POST" enctype="multipart/form-data">
                    <label>Event Name:</label>
                    <input type="text" name="event_name" class="form-control" required>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Date of Event:</label>
                            <input type="date" name="event_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Venue:</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($venue['name']); ?>" disabled>
                        </div>
                    </div>

                    <label>Start Time:</label>
                    <input type="time" name="start_time" class="form-control" required>
                    <label>End Time:</label>
                    <input type="time" name="end_time" class="form-control" required>

                    <label>Full Name:</label>
                    <input type="text" name="full_name" class="form-control" required>

                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" class="form-control" required>
                    <label>Email Address:</label>
                    <input type="email" name="email" class="form-control" required>

                    <label>Number of Attendees:</label>
                    <input type="number" name="num_attendees" class="form-control" required>

                    <label>Upload ID for Verification:</label>
                    <input type="file" name="id_photo" class="form-control" accept="image/*" required>

                    <label>Additional Requests:</label>
                    <textarea name="requests" class="form-control"></textarea>

                    <label>Total Cost:</label>
                    <input type="text" class="form-control" value="₱<?= number_format($venue['price'], 2); ?>" readonly>

                    <label>Payment Method:</label>
                    <input type="radio" name="payment_method" value="Cash" required> Cash
                    <input type="radio" name="payment_method" value="Credit/Debit"> Credit/Debit
                    <input type="radio" name="payment_method" value="Online"> Online

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="shared_booking" id="shared_booking" value="1">
                        <label class="form-check-label" for="shared_booking">
                            Allow shared booking
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Book Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-md-7">
    <div class="venue-details">
        <h2><?= htmlspecialchars($venue['name']); ?></h2>
        <img src="<?= htmlspecialchars($venue['image']); ?>" alt="<?= htmlspecialchars($venue['name']); ?>">
        <p class="mt-3"><?= nl2br(htmlspecialchars($venue['description'])); ?></p>
    </div>
</div>


        <!-- 📌 Show Google Map only for Venue ID = 1 -->
        <?php if ($venue_id == 1) { ?>
            <div class="mt-5">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.715672218494!2d120.97303237649983!3d14.55351458591883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d300a31d7641%3A0x459c7332f81c294a!2sMolino%201%20(Progressive%2018)%20Covered%20Court!5e0!3m2!1sen!2sph!4v1742210443642!5m2!1sen!2sph"
                    width="50%" 
                    height="450" 
                    style="border:0; border-radius:10px; box-shadow:0px 4px 8px rgba(0, 0, 0, 0.1);" 
                    margin-left="45%"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        <?php } ?>

        <?php if ($venue_id == 2) { ?>
            <div class="mt-5">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.715672218494!2d120.97303237649983!3d14.55351458591883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d300a31d7641%3A0x459c7332f81c294a!2sMolino%201%20(Progressive%2018)%20Covered%20Court!5e0!3m2!1sen!2sph!4v1742210443642!5m2!1sen!2sph"
                    width="50%" 
                    height="450" 
                    style="border:0; border-radius:10px; box-shadow:0px 4px 8px rgba(0, 0, 0, 0.1);" 
                    margin-left="45%"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        <?php } ?>
  


</body>
</html>
