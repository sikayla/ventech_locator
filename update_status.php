<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "venue_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["booking_id"]) || !isset($_POST["action"])) {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
        exit;
    }

    $booking_id = intval($_POST["booking_id"]);
    $status = $_POST["action"];

    if (!in_array($status, ["Approved", "Rejected"])) {
        echo json_encode(["success" => false, "message" => "Invalid status value."]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $booking_id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Booking status updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update status."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
