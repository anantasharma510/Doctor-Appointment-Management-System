
<?php
include_once('dams/include/config.php');
if (isset($_POST['submit'])) {
    $name = $_POST['fullname'];
    $email = $_POST['emailid'];
    $mobileno = $_POST['mobileno'];
    $dscrption = $_POST['description'];

    // Server-side validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format. Please enter a valid email.');</script>";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobileno)) {
        echo "<script>alert('Invalid mobile number. Please enter a 10-digit number.');</script>";
    } else {
        // Insert data into the database if validation passes
        $query = mysqli_query($con, "INSERT INTO tblcontactus (fullname, email, contactno, message) VALUES ('$name', '$email', '$mobileno', '$dscrption')");
        if ($query) {
            echo "<script>alert('Your information was successfully submitted');</script>";
            echo "<script>window.location.href ='index.php'</script>";
        } else {
            echo "<script>alert('Submission failed. Please try again.');</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Doctor Appointment management System </title>

    <link rel="shortcut icon" href="assets/images/fav.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawsom-all.min.css">
     <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>

    <body>

    <!-- ################# Header Starts Here#######################--->
    
      <header id="menu-jk">
    
        <div id="nav-head" class="header-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-3  col-sm-12" style="color:#000;font-weight:bold; font-size:42px; margin-top: 1% !important;">DAMS
                       <a data-toggle="collapse" data-target="#menu" href="#menu" ><i class="fas d-block d-md-none small-menu fa-bars"></i></a>
                    </div>
                    <div id="menu" class="col-lg-8 col-md-9 d-none d-md-block nav-item">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#about_us">About Us</a></li>
                            <li><a href="#gallery">Gallery</a></li>
                            <li><a href="#contact_us">Contact Us</a></li>
                            <li><a href="#logins">Logins</a></li>  
                        </ul>
                    </div>
                    <div class="col-sm-2 d-none d-lg-block appoint">
                        <a class="btn btn-success" href="dams/user-login.php">Book an Appointment</a>
                    </div>
                </div>

            </div>
        </div>
    </header><style>
        .slider {
    position: relative;
    max-width: 100%;
    overflow: hidden;
  }
  
  /* Wrapper for the images to handle sliding */
  .slider-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
  }
  
  /* Styling for each image in the slider */
  .slider img {
    width: 100%;
    height: auto;
    object-fit: cover;
    flex-shrink: 0;
  }
  /* Prevent image dragging */
.slider img {
    user-drag: none;
    user-select: none;
    -moz-user-select: none;
    -webkit-user-drag: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    pointer-events: none;
  }
  
  
  /* Styling for the text overlay */
  .slider-text {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: #fff;
    background: rgba(0, 0, 0, 0.5);
    padding: 10px 20px;
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
    z-index: 10;
  }
  
  /* Responsive adjustments for tablets */
  @media (max-width: 768px) {
    .slider-text {
      font-size: 1.25rem;
      padding: 8px 16px;
    }
  }
  
  /* Responsive adjustments for mobile devices */
  @media (max-width: 480px) {
    .slider-text {
      font-size: 1rem;
      padding: 6px 12px;
    }
  }
  
  /* Styling for the navigation arrows */
  .slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    border: none;
    color: white;
    font-size: 2rem;
    padding: 10px;
    cursor: pointer;
    z-index: 10;
    border-radius: 50%;
  }
  
  .left-arrow {
    left: 10px;
  }
  
  .right-arrow {
    right: 10px;
  }
  
  /* Hover effect for arrows */
  .slider-arrow:hover {
    background: rgba(0, 0, 0, 0.7);
  }</style><Script>
    
const sliderWrapper = document.querySelector('.slider-wrapper');
const slides = document.querySelectorAll('.slider img');
const leftArrow = document.querySelector('.left-arrow');
const rightArrow = document.querySelector('.right-arrow');

let currentIndex = 0;
const totalSlides = slides.length;

function updateSliderPosition() {
  const width = sliderWrapper.clientWidth;
  sliderWrapper.style.transform = `translateX(-${currentIndex * width}px)`;
}

function showNextSlide() {
  currentIndex = (currentIndex + 1) % totalSlides;
  updateSliderPosition();
}

function showPreviousSlide() {
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  updateSliderPosition();
}

rightArrow.addEventListener('click', showNextSlide);
leftArrow.addEventListener('click', showPreviousSlide);

// Disable image dragging
slides.forEach(img => {
  img.addEventListener('dragstart', (e) => {
    e.preventDefault();
  });
});

// Swipe functionality for touch and mouse devices
let startX, isDragging = false;

function startDragging(e) {
  startX = e.clientX || e.touches[0].clientX;
  isDragging = true;
}

function duringDragging(e) {
  if (!isDragging) return;
  const moveX = e.clientX || e.touches[0].clientX;
  const diffX = startX - moveX;

  if (diffX > 50) {
    showNextSlide();
    isDragging = false;
  } else if (diffX < -50) {
    showPreviousSlide();
    isDragging = false;
  }
}

function stopDragging() {
  isDragging = false;
}

// Event listeners for mouse dragging
sliderWrapper.addEventListener('mousedown', startDragging);
sliderWrapper.addEventListener('mousemove', duringDragging);
sliderWrapper.addEventListener('mouseup', stopDragging);
sliderWrapper.addEventListener('mouseleave', stopDragging);

// Event listeners for touch dragging
sliderWrapper.addEventListener('touchstart', startDragging);
sliderWrapper.addEventListener('touchmove', duringDragging);
sliderWrapper.addEventListener('touchend', stopDragging);

// Handle window resize to adjust slider position
window.addEventListener('resize', updateSliderPosition);

// Initial position
updateSliderPosition();
    </script>
    
     <!-- ################# Slider Starts Here#######################--->
     <div class="slider">
    <div class="slider-wrapper">
        <img src="assets/images/images/slider1.png" alt="Slider Image">
        <img src="assets/images/images/slider3.png" alt="Slider Image">
        <img src="assets/images/images/slider2.png" alt="Slider Image">
    </div>
   
 
</div>

    
  <!--  ************************* Logins ************************** -->
  <section id="logins">
    <h2>Logins</h2>
    <div class="login-card">
        <img src="assets/images/patient.jpg" alt="Patient Login">
        <h6>Login</h6>
        <a href="dams/user-login.php" target="_blank">
            <button>Click Here</button>
        </a>
    </div>
</section>
<style>
    #logins {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 20px;
    margin: 0 auto;
}button {
    padding: 10px 20px;
    background-color: #007bff; /* Primary blue color */
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover {
    background-color: #0056b3; /* Darker blue on hover */
    transform: scale(1.05); /* Slight zoom effect */
}

button:active {
    transform: scale(0.95); /* Slight press-in effect */
}


</style>







    <!-- ################# Our Departments Starts Here#######################--->


    <div id="services">
    <section class="key-features-section">
        <div class="container">
            <div class="intro-text">
                <h2>Our Key Features</h2>
                <p>Take a look at some of our key features</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                            <path d="M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>24/7 Medical Care</h3>
                        <p>Our healthcare services are available around the clock to ensure you receive the care you need, whenever you need it.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Personalized Treatment</h3>
                        <p>Our team of healthcare professionals work closely with you to develop a personalized treatment plan tailored to your specific needs.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Secure Data Privacy</h3>
                        <p>We take the security and privacy of your medical data seriously, ensuring it is protected with the highest standards of encryption and access control.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 18h8"></path>
                            <path d="M3 22h18"></path>
                            <path d="M14 22a7 7 0 1 0 0-14h-1"></path>
                            <path d="M9 14h2"></path>
                            <path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"></path>
                            <path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Advanced Diagnostics</h3>
                        <p>Our state-of-the-art diagnostic equipment and experienced medical staff ensure accurate and comprehensive testing to provide you with the best possible care.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path>
                            <path d="m8.5 8.5 7 7"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Comprehensive Treatments</h3>
                        <p>Our healthcare services cover a wide range of treatments, from preventative care to specialized procedures, ensuring you receive the comprehensive care you need.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 10H6"></path>
                            <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path>
                            <path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"></path>
                            <path d="M8 8v4"></path>
                            <path d="M9 18h6"></path>
                            <circle cx="17" cy="18" r="2"></circle>
                            <circle cx="7" cy="18" r="2"></circle>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Emergency Services</h3>
                        <p>In case of emergencies, our dedicated team is ready to provide immediate and efficient medical care to ensure your safety.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    </div>
    
  <style> 
  
/* Features Section Styles */
.key-features-section {
    padding: 3rem 1rem;
    background-color: #F9F9F9;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.intro-text {
    text-align: center;
    margin-bottom: 2rem;
}

.intro-text h2 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.intro-text p {
    font-size: 1rem;
    color: #777;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.feature-card {
    background-color: #FFFFFF;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}

.icon-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 1rem;
}

.icon-wrapper svg {
    width: 40px;
    height: 40px;
    color: #4CAF50;
}

.feature-content h3 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.feature-content p {
    font-size: 1rem;
    color: #555;
    line-height: 1.5;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .login-container {
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .login-item {
        width: 80%;
        margin-bottom: 20px;
    }

    .intro-text h2 {
        font-size: 1.8rem;
    }

    .intro-text p {
        font-size: 0.9rem;
    }

    .feature-card {
        padding: 1.5rem;
    }

    .feature-content h3 {
        font-size: 1.3rem;
    }

    .feature-content p {
        font-size: 0.9rem;
    }
}

@media screen and (max-width: 480px) {
    .login-item {
        width: 95%;
        padding: 15px;
    }

    .feature-card {
        padding: 1rem;
    }

    .intro-text h2 {
        font-size: 1.5rem;
    }

    .intro-text p {
        font-size: 0.8rem;
    }

    .feature-content h3 {
        font-size: 1.2rem;
    }

    .feature-content p {
        font-size: 0.8rem;
    }
}

  </style>
    
    <!--  ************************* About Us Starts Here ************************** -->
        
    <section id="about_us" class="about-us">
        <div class="row no-margin">
            <div class="col-sm-6 image-bg no-padding">
                
            </div>
            <div class="col-sm-6 abut-yoiu">
                <h3>About Our Hospital</h3><?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = mysqli_connect("localhost", "root", "", "hms");

$ret = mysqli_query($con, "SELECT * FROM tblpage WHERE PageType='aboutus'");
while ($row = mysqli_fetch_array($ret)) {
?>
    <p><?php echo $row['PageDescription']; ?>.</p>
<?php } ?>

            </div>
        </div>
    </section>    
    
    
            <!--  ************************* Gallery Starts Here ************************** -->
        <div id="gallery" class="gallery">    
           <div class="container">
              <div class="inner-title">

                <h2>Our Gallery</h2>
                <p>View Our Gallery</p>
            </div>
              <div class="row">
                

        <div class="gallery-filter d-none d-sm-block">
            <button class="btn btn-default filter-button" data-filter="all">All</button>
            <button class="btn btn-default filter-button" data-filter="hdpe">Dental</button>
            <button class="btn btn-default filter-button" data-filter="sprinkle">Cardiology</button>
            <button class="btn btn-default filter-button" data-filter="spray"> Neurology</button>
            <button class="btn btn-default filter-button" data-filter="irrigation">Laboratry</button>
        </div>
        <br/>



            <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
                <img src="assets/images/gallery/gallery_01.jpg" class="img-responsive">
            </div>

            <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter sprinkle">
                <img src="assets/images/gallery/gallery_02.jpg" class="img-responsive">
            </div>

            <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
                <img src="assets/images/gallery/gallery_03.jpg" class="img-responsive">
            </div>

            <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter irrigation">
                <img src="assets/images/gallery/gallery_04.jpg" class="img-responsive">
            </div>

            <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray">
                <img src="assets/images/gallery/gallery_05.jpg" class="img-responsive">
            </div>

          

            <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray">
                <img src="assets/images/gallery/gallery_06.jpg" class="img-responsive">
            </div>

        </div>
    </div>
       
       
       </div>
        <!-- ######## Gallery End ####### -->
    
    
     <!--  ************************* Contact Us Starts Here ************************** -->
    
     <section id="contact_us" class="contact-us-single">
    <div class="row no-margin">
        <div class="col-sm-12 cop-ck">
            <form method="post">
                <h2>Contact Form</h2>
                <div class="row cf-ro">
                    <div class="col-sm-3"><label>Enter Name:</label></div>
                    <div class="col-sm-8"><input type="text" placeholder="Enter Name" name="fullname" class="form-control input-sm" required></div>
                </div>
                <div class="row cf-ro">
                    <div class="col-sm-3"><label>Email Address:</label></div>
                    <div class="col-sm-8">
                        <input type="email" name="emailid" placeholder="Enter Email Address" class="form-control input-sm" required 
                        title="Please enter a valid email address.">
                    </div>
                </div>
                <div class="row cf-ro">
                    <div class="col-sm-3"><label>Mobile Number:</label></div>
                    <div class="col-sm-8">
                        <input type="text" name="mobileno" placeholder="Enter Mobile Number" class="form-control input-sm" required 
                        pattern="[0-9]{10}" title="Please enter a valid 10-digit mobile number.">
                    </div>
                </div>
                <div class="row cf-ro">
                    <div class="col-sm-3"><label>Enter Message:</label></div>
                    <div class="col-sm-8">
                        <textarea rows="5" placeholder="Enter Your Message" class="form-control input-sm" name="description" required></textarea>
                    </div>
                </div>
                <div class="row cf-ro">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-8">
                        <button class="btn btn-success btn-sm" type="submit" name="submit">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

    
    
    
    
    <!-- ################# Footer Starts Here#######################--->

    <footer class="footer">
        <style> 
        
        
/* Footer Styles */
.footer {
    background-color: #4c8ad2;
    color: #ecf0f1;
    padding: 60px 20px;
    position: relative;
    z-index: 10;
    line-height: 1.6;
    box-sizing: border-box;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.footer-column {
    flex: 1;
    min-width: 250px;
    margin: 10px 0;
}

.footer-column h5 {
    font-size: 18px;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
    color: #f39c12;
    border-bottom: 2px solid #f39c12;
    transition: all 0.3s ease;
}

.footer-column h5:hover {
    color: #ecf0f1;
    border-color: #ecf0f1;
}

.footer-column ul {
    list-style: none;
    padding: 0;
}

.footer-column ul li {
    margin-bottom: 15px;
}

.footer-column ul li a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-column ul li a:hover {
    color: #f39c12;
}

.footer-column ul.social-icons {
    display: flex;
    gap: 15px;
    padding-top: 20px;
}

.footer-column ul.social-icons li {
    display: inline-block;
}

.footer-column ul.social-icons li a {
    color: #bdc3c7;
    font-size: 20px;
    transition: transform 0.3s ease, color 0.3s ease;
}

.footer-column ul.social-icons li a:hover {
    color: #f39c12;
    transform: scale(1.2);
}

.footer-bottom {
    text-align: center;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #7f8c8d;
}

.footer-bottom p {
    font-size: 14px;
    color: fff;
    margin: 0;
}

/* Smooth Transition */
.footer * {
    transition: all 0.3s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
    }
    .footer-column {
        max-width: 100%;
        text-align: center;
    }
    .footer-column ul.social-icons {
        justify-content: center;
    }
}

/* Mobile View */
@media (max-width: 480px) {
    .footer {
        padding: 40px 15px;
    }
    .footer-bottom p {
        font-size: 12px;
    }
}
.footer-column ul.social-icons {
    display: flex;
    gap: 15px;
    padding-top: 20px;
}

.footer-column ul.social-icons li {
    display: inline-block;
}

.footer-column ul.social-icons li a {
    color: #bdc3c7; /* Initial color of the icons */
    font-size: 20px; /* Size of the icons */
    transition: transform 0.3s ease, color 0.3s ease; /* Smooth transition for hover effects */
}

.footer-column ul.social-icons li a:hover {
    color: #f39c12; /* Color change on hover */
    transform: scale(1.2); /* Slightly increase size on hover */
}

        </style>
        <div class="footer-container">
            <div class="footer-column">
                <h5>Navigate</h5>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about_us">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#contact_us">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h5>Services</h5>
                <ul>
                    <li><a href="#">Emergency Help</a></li>
                    <li><a href="#">Doctors</a></li>
                    <li><a href="#">Appointment</a></li>
                    <li><a href="#">Surgery</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h5>Contact</h5>
                <ul>
                    <li><a href="#">Pokhara, Nepal</a></li>
                    <li><a href="#">Phone: 9814167623</a></li>
                    <li><a href="#">Email: bca4thsemproject@gmail.com</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h5>Stay Connected</h5>
                <ul>
    <li><a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
    <li><a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
    <li><a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a></li>
    <li><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
    <li><a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li>
</ul>


        </div>
        <div class="footer-bottom" ><style>
           
            </style>
            <p>&copy; 2025 Doctor Appointment Management System. All Rights Reserved.</p>
        </div>
    </footer>
    <div class="copy">
            <div class="container">
                <style>.copy{
                     background-color: #4c8ad2;
                }
                    </style>
       
                
     
            </div>

        </div>
    
    </body>

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/plugins/scroll-nav/js/jquery.easing.min.js"></script>
<script src="assets/plugins/scroll-nav/js/scrolling-nav.js"></script>
<script src="assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js"></script>

<script src="assets/js/script.js"></script>



</html>