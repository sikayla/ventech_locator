<?php 
include 'config.php';

// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php"); // Redirect to login page if not logged in
    exit();
}

$query = "SELECT * FROM properties";
$result = $conn->query($query);
$properties = [];

while ($row = $result->fetch_assoc()) {
    $properties[] = $row;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VENTECH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <!-- Bootstrap CSS for responsiveness -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <style>
        body { overflow:  hidden;display: flex; flex-direction: row; height: 100vh; background-color: #9db2d0; }
        
        .property-panel { width: 300px;
    background: #fff;
    padding: 15px;
    position: absolute;
    top: 10px;
    right: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-height: 800px;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 10px;}
        .property-image { width: 100%; height: 150px; object-fit: cover; }
        .nav-item{ font-family: "Roboto", "Helvetica Neue", sans-serif; font-size: 20px; font-weight: bold;} 
        .nav .flex-column{ margin-top: 20%; padding-top: 20%;}
        .flex-column{ flex-direction: column !important; padding-top: 80%; padding-left: 15px;}
        .container.mt-4{ background-color: #9db2d0;}
        .nav-link{color: #fff;}
        .h3, h3{font-size: calc(0.9rem + .6vw); padding-left: 15px; color: white;}
        .sidebar { width: 250px; background:#383f45; padding: 20px; }
        .property-panel { width: 300px;
    background: #fff;
    padding: 15px;
    position: absolute;
    top: 10px;
    right: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-height: 800px;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 10px;}
    .search-bar {
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(255, 255, 255, 0.9);
    padding: 8px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    width: 300px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000; /* Ensure it appears on top */
    margin-left: -10%;
    margin-top: 12px;

}
        .search-bar input {
            border: none;
            outline: none;
            padding: 8px;
            font-size: 16px;
            width: 100%;
            border-radius: 20px;
        }
        .search-bar button {
            background-color: #ff6f61;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-bar button:hover {
            background-color: #e65c4f;
        }
        @media (max-width: 600px) {
            .search-bar {
                width: 90%;
            }
        }
        .mt-4{margin-top: -2rem !important;}

        #map {
    height: 750px;
    width: 490%;
    margin-left: 120%;
    margin-top: -261%;
    position: relative;
    z-index: 1;
}
        .text-center h2{ margin-top: 20%;}

        .marker-number {
            background-color: #007bff;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Ventech Venue</h3>

<div class="nav flex-column">
    <li class="nav-item">
        <a href="dashboard.php" class="nav-link">
            <i class="material-icons">📍</i> Map
        </a>
    </li>


    <li class="nav-item">
        <a href="list_venues.php" class="nav-link">
        <i class="material-icons">🏢 </i> List Venue
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
        <i class="material-icons">💬</i> Enquiries
        </a>
    </li>
    <li class="nav-item">
        <a href="manage_bookings.php" class="nav-link">
        <i class="material-icons">📖</i> Bookings
        </a>
    </li>

    <br>

      </br>
    <li class="nav-item">
        <a href="signout.php" class="nav-link">
        <i class="material-icons">🔑</i> Signout
        </a>
    </li>

    <li class="nav-item">
        <a href="profile.php" class="nav-link">
        <i class="material-icons">👤 </i> Profile
        </a>
    </li>
    </ul>

    </div>

   

  
    <div class="search-bar">
    <input type="text" id="searchInput" onkeyup="filterMarkers()" placeholder="Search venues...">
    <button onclick="clearSearch()">Clear</button>
</div>
    <div id="map">
</div>
</div>
    <div class="property-panel">
        </div>
</div>
        <div class="property-panel">
            <h4>Venue Listings</h4>
            <?php foreach ($properties as $property): ?>
                <div class="card mb-3">
                    <img src="<?php echo $property['image_url']; ?>" class="property-image" alt="Property">
                    <div class="card-body">
                        <span class="badge bg-<?php echo strtolower($property['property_type']) == 'commercial' ? 'purple' : 'green'; ?>">
                            <?php echo ucfirst($property['property_type']); ?> VENTECH
                        </span>
                        <h5 class="card-title"><?php echo $property['title']; ?></h5>
                        <p class="card-text"><?php echo substr($property['description'], 0, 80); ?>...</p>
                        <p><strong>₱<?php echo number_format($property['price'], 2); ?></strong></p>
                        <button class="btn btn-primary">View Detailsa</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
  

    
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
    // Initialize the map
    var map = L.map('map').setView([14.3914, 120.982], 15);

    // Load OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Venue locations with id added
    var locations = [
        { id: 1, name: "Molino 3 Bacoor 3 Basketball Court", lat: 14.3914, lng: 120.982 },
        { id: 2, name: "Bacoor City Hall", lat: 14.3895, lng: 120.984 },
        { id: 3, name: "SM City Bacoor", lat: 14.3950, lng: 120.980 },
        { id: 4, name: "St. Dominic College", lat: 14.3872, lng: 120.987 },
        { id: 5, name: "LOWLAND COVERED COURT", lat: 14.3750, lng: 120.985 },
        { id: 6, name: "Soldiers Hills IV Phase 2 Covered Court", lat: 14.3875, lng: 120.980 },
        { id: 7, name: "SAN LORENZO RUIZ HOMES COVERED COURT", lat: 14.3800, lng: 120.972 },
        { id: 8, name: "Molino 1 (Progressive 18) Covered Court", lat: 14.3925, lng: 120.975 }
    ];

    // Store markers for filtering
    var markers = [];

    // Add markers to the map
    locations.forEach(function(location) {
        var marker = L.marker([location.lat, location.lng]).addTo(map)
            .bindPopup(`
                <b>${location.name}</b><br>
                <button onclick="viewMore(${location.id})" class="btn btn-primary btn-sm mt-2">
                    View More
                </button>
            `);
        markers.push({ name: location.name, marker: marker });
    });

    // Function to redirect to venue details page
    function viewMore(id) {
        window.location.href = "venue_details.php?id=" + id;
    }

    // Function to filter markers based on search
    function filterMarkers() {
    var input = document.getElementById("searchInput").value.toLowerCase();
    markers.forEach(function(entry) {
        if (entry.name.toLowerCase().includes(input)) {
            if (!map.hasLayer(entry.marker)) { 
                entry.marker.addTo(map); // Show if it matches
            }
        } else {
            entry.marker.remove(); // Hide if not a match
        }
    });
}
    // Function to clear search and show all markers
    function clearSearch() {
    document.getElementById("searchInput").value = "";
    markers.forEach(function(entry) {
        if (!map.hasLayer(entry.marker)) {
            entry.marker.addTo(map);
        }
    });
}
</script>
</body>
</html>
