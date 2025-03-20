<?php
// Sample details (Replace with database data if needed)
$title = "Molino 3 Bacoor 3 Basketball Court";
$description = "A popular basketball court located in Molino 3, Bacoor, Cavite. Great for pickup games and local tournaments.";
$image = "basketball_court.jpg"; // Replace with an actual image path
$latitude = 14.3914;  // Adjust to correct latitude
$longitude = 120.982; // Adjust to correct longitude
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center"><?php echo $title; ?></h2>
    <p class="text-center"><?php echo $description; ?></p>

    <!-- Image -->
    <div class="text-center">
        <img src="<?php echo $image; ?>" alt="Basketball Court" class="img-fluid rounded shadow" style="max-width: 600px;">
    </div>

    <!-- Embedded Google Map -->
    <div class="mt-4 text-center">
        <h4>Location:</h4>
        <iframe
            width="600"
            height="450"
            style="border:0"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q=<?php echo $latitude . ',' . $longitude; ?>">
        </iframe>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">Back to Map</a>
    </div>
</div>

</body>
</html>
