<?php
// Include any necessary PHP code or variables here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventech - Find Event Spaces</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style4.css">
    <script defer src="js/script.js"></script>
    <script defer src="js/script4.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <header>
        <div class="logo">Ventech</div>
        <nav>
            <a href="../ven/index.php" class=""><i class="fas fa-home"></i> Home</a>
            <a href="#"><i class="fas fa-envelope"></i> Inquire</a>
            <a href="#"><i class="fas fa-bullhorn"></i> Advertise</a>
            <a href="#"><i class="fas fa-plus-circle"></i> List Your Venue</a>
        </nav>
        <button class="login-btn"><i class="fas fa-sign-in-alt"></i> Login/Register</button>
    </header>

    <div class="slideshow-container">
        <div class="slide fade">
            <img src="images/court1.jpg" alt="Venue 1">
        </div>
        <div class="slide fade">
            <img src="images/court2.jpg" alt="Venue 2">
        </div>
        <div class="slide fade">
            <img src="images/court3.jpg" alt="Venue 3">
        </div>

        <!-- Navigation Arrows -->
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>

    <section>

        <!-- Listing Content -->
        <div class="listing-container">
            <div class="listing-details">
                <div class="tags">
                    <span class="tag">Practisan</span>
                    <span class="tag">Ameneties</span>
                    <span class="tag">Activities</span>
                    <span class="tag">School Purposes</span>
                </div>

                <div class="price">₱500 - ₱1,000</div>
                <div class="title">SAN LORENZO RUIZ HOMES COVERED COURT/SANGGUNIANG KABATAAN MOLINO 7 OFFIC</div>
                <div class="location"><i class="fas fa-map-marker-alt"></i> Bacoor, Cavite</div>

                <div class="booking-info">
                    <h3>Overview</h3>
                    <p><strong>Pricing Model:</strong> WALA PA</p>
                    <p><strong>Accessibility:</strong> TEKA</p>
                    <p><strong>Food & Dining:</strong>PAGPAG</p>
                </div>
            </div>

            <!-- Booking Form -->
            <section>
                <div class="booking-box">
                    <h3>Book Now</h3>
                    <label>Date</label>
                    <input type="date" id="date">
                    <label>Start Time</label>
                    <input type="time" id="start-time">
                    <label>End Time</label>
                    <input type="time" id="end-time">
                    <label>Guests</label>
                    <select id="guests">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>
                    <button onclick="calculatePrice()" class="booking-button">Request Booking</button>
                    <p class="total-cost">Total Cost: ₱<span id="total-price">0</span></p>
                </div>
            </section>
        </div>
    </section>

    <br>

    <button id="scrollToSection1">OVERVIEW</button>
    <button id="scrollToSection2">VENUE TYPE</button>
    <button id="scrollToSection3">LOCATION</button>

    <div id="section1" style="margin-left: 2%; height: 1000px;  background-color: rgb(236, 236, 236);  margin-top: 20px; width: 1230px; border-radius: 10px;">

        <div style="padding-top: 30px; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">OVERVIEW</div>

        <div class="tab-content" id="overview">
            <div class="details">
                <div class="detail-item">
                    <img src="images/price-tag.png" alt="Pricing Model">
                    <strong>Pricing Model</strong>
                </div>
                <div class="detail-item">
                    <img src="images/security.png" alt="Accessibility">
                    <strong>Accessibility</strong>
                    <p></p>
                </div>
                <div class="detail-item">
                    <img src="images/dinning.png" alt="Food & Dining">
                    <strong>Food & Dining</strong>
                    <p></p>
                </div>
            </div>
            <div class="icons-row">
                <div class="icon-item">
                    <img src="images/hourglass.png" alt="Free Ingress Hours">
                    <strong>5 Free Ingress Hours</strong>
                </div>
                <div class="icon-item">
                    <img src="images/hourglass.png" alt="Free Egress Hours">
                    <strong>1 Free Egress Hours</strong>
                </div>
                <div class="icon-item">
                    <img src="images/hourglass.png" alt="Guest Capacity">
                    <strong>80 Guest Capacity</strong>
                </div>
            </div>
            <br>
            <br>
            <div class="description">
                <p>Our Enclosed Pavilion is a versatile space, perfect for intimate gatherings and casual events.
                    <br> With its airy, open-concept design and natural lighting, it offers a relaxed and inviting atmosphere.</p>
                <p>Whether you're hosting a family reunion, a team-building activity, or a small conference, this space can be easily
                    <br> configured to suit your needs. Experience a unique blend of rustic charm and modern comfort at Villa Excellance 
                    <br>Beach & Wave Pool Resort.</p>
                <div class="booking-details">
                    <p>The Enclosed Pavilion can be rented for a minimum of 4 hours (Php20,000), 8 hours (Php40,000) or 
                        <br>full day up to 12 hours (Php60,000). Please select at least 4 hours schedule when you send 
                        <br>booking request.</p>
                </div>
            </div>
        </div>

        <div class="tab-content" id="location" style="display: none;">
            <p>Location details will go here.</p>
        </div>
    </div>

    </div>

    <div id="section2" style="margin-left: 2%; height: 900px;  background-color: rgb(236, 236, 236);  margin-top: 20px; width: 1230px; border-radius: 10px;">


        <div class="container3">
            <h2>Venue Type</h2>
            <div class="event-types">
                <div class="type-item">
                    <img src="images/team.png" alt="Ballroom">
                    Avctivities
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Banquet Hall">
                    Event Place
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Events Place">
                    Events Place
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Events Place">
                    Events Place
                </div>
            </div>

            <h2>Event Types</h2>

            <div class="event-types">
                <div class="type-item">
                    <img src="images/location.png" alt="Anniversary Party">
                    Anniversary Party
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Annual Meet">
                    Annual Meet
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Awarding Ceremony">
                    Awarding Ceremony
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Baptism Ceremony">
                    Baptism Ceremony
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Baptism Reception">
                    Baptism Reception
                </div>
                <div class="type-item">
                    <img src="images/location.png" alt="Birthday Party">
                    Birthday Party
                </div>
            </div>
        </div>
    </section>

    <br>

    <section>

        <div id="section3" style="margin-left: 0%; height: 900px;  background-color: rgb(236, 236, 236);  margin-top: 15%; width: 1230px; border-radius: 10px;">


            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3864.4150741290564!2d120.99498677510232!3d14.403219886060105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d139e4c67bb3%3A0x655c6f30fc658a6e!2sSAN%20LORENZO%
        20RUIZ%20HOMES%20COVERED%20COURT%2FSANGGUNIANG%20KABATAAN%20MOLINO%207%20OFFICE!5e0!3m2!1sen!2sph!4v1740720725769!5m2!1sen!2sph"
             width="1225" height="1000" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>

    </section>


    <script>
        document.getElementById('scrollToSection1').addEventListener('click', function () {
            scrollToElement('section1');
        });

        document.getElementById('scrollToSection2').addEventListener('click', function () {
            scrollToElement('section2');
        });

        document.getElementById('scrollToSection3').addEventListener('click', function () {
            scrollToElement('section3');
        });


        function scrollToElement(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' }); // Use 'smooth' for animated scrolling
            }
        }
    </script>


</body>

</html>
