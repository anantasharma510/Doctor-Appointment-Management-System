<?php
session_start();
error_reporting(0);
include("include/config.php");

// Handle form submission for password recovery
if (isset($_POST['submit'])) {
    if (isset($_POST['user_type'])) {
        $user_type = $_POST['user_type'];
        
        // Doctor password recovery
        if ($user_type == 'doctor' && isset($_POST['contactno']) && isset($_POST['email'])) {
            $contactno = $_POST['contactno'];
            $email = $_POST['email'];
            $query = mysqli_query($con, "SELECT id FROM doctors WHERE contactno='$contactno' AND docEmail='$email'");
            $row = mysqli_num_rows($query);
            if ($row > 0) {
                $_SESSION['cnumber'] = $contactno;
                $_SESSION['email'] = $email;
                header('location:./doctor/reset-password.php');
                exit();
            } else {
                echo "<script>alert('Invalid details. Please try with valid details');</script>";
            }
        }
        
        // Patient password recovery
        elseif ($user_type == 'patient' && isset($_POST['fullname']) && isset($_POST['email'])) {
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $query = mysqli_query($con, "SELECT id FROM users WHERE fullName='$name' AND email='$email'");
            $row = mysqli_num_rows($query);
            if ($row > 0) {
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                header('location:reset-password.php');
                exit();
            } else {
                echo "<script>alert('Invalid details. Please try with valid details');</script>";
            }
        } else {
            echo "<script>alert('Please provide the required information');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Recovery</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
</head>
<body class="login">
<div class="row">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="logo margin-top-30">
            <a href="../../index.php"><h2>DAMS | Password Recovery</h2></a>
        </div>

        <div class="box-login">
            <form class="form-login" method="post">
                <fieldset>
                    <legend>Password Recovery</legend>
                    <p>Please enter your details to recover your password.</p>

                    <div class="form-group">
                        <label>Are you a Doctor or a Patient?</label><br>
                        <input type="radio" name="user_type" value="doctor" checked> Doctor
                        <input type="radio" name="user_type" value="patient"> Patient
                    </div>

                    <!-- Doctor fields -->
                    <div class="form-group form-actions" id="doctor-fields">
                        <span class="input-icon">
                            <input type="text" class="form-control" name="contactno" placeholder="Registered Contact Number">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <!-- Patient fields -->
                    <div class="form-group" id="patient-fields">
                        <span class="input-icon">
                            <input type="text" class="form-control" name="fullname" placeholder="Registered Full Name">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="email" class="form-control" name="email" placeholder="Registered Email">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary pull-right" name="submit">Reset <i class="fa fa-arrow-circle-right"></i></button>
                    </div>

                    <div class="new-account">
                        Already have an account? <a href="index.php">Log-in</a>
                    </div>
                </fieldset>
            </form>

            <div class="copyright">
                <span class="text-bold text-uppercase">Hospital Management System</span>
            </div>

        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/login.js"></script>

<script>
jQuery(document).ready(function() {
    // Show/hide input fields based on user type (doctor or patient)
    $("input[name='user_type']").change(function() {
        var userType = $("input[name='user_type']:checked").val();
        if (userType === "doctor") {
            // Show Doctor fields and hide Patient fields
            $("#doctor-fields").show();
            $("#patient-fields").hide();
            // Reset Patient fields when switching to Doctor
            $("input[name='fullname']").val('');
        } else {
            // Show Patient fields and hide Doctor fields
            $("#doctor-fields").hide();
            $("#patient-fields").show();
            // Reset Doctor fields when switching to Patient
            $("input[name='contactno']").val('');
        }
    });

    // Initialize based on the default selection (doctor)
    if ($("input[name='user_type']:checked").val() === "doctor") {
        $("#doctor-fields").show();
        $("#patient-fields").hide();
    }
});

</script>

</body>
</html>
