<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

// Function to generate available time slots
function generateTimeSlots() {
    $start = strtotime("11:00");
    $end = strtotime("17:00");
    $timeSlots = [];

    while ($start < $end) {
        $timeSlots[] = date("h:i A", $start);
        $start = strtotime("+30 minutes", $start);
    }

    return $timeSlots;
}

if (isset($_POST['submit'])) {
    $specilization = $_POST['Doctorspecialization'];
    $doctorid = $_POST['doctor'];
    $userid = $_SESSION['id'];
    $fees = $_POST['fees'];
    $appdate = $_POST['appdate'];
    $time = $_POST['apptime'];
    $status = 1;

	// Check if the doctor is unavailable on the selected date
$stmt = $con->prepare("SELECT * FROM doctor_unavailable_dates WHERE doctorId = ? AND unavailableDate = ?");
$stmt->bind_param("is", $doctorid, $appdate);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['error_msg'] = "The selected doctor is unavailable on this date.";
    $stmt->close();
    header("Location: book-appointment.php");
    exit;
}


	// Check if the selected date is a Saturday
	$dayOfWeek = date('l', strtotime($appdate));
    if ($dayOfWeek == 'Saturday') {
        $_SESSION['error_msg'] = "Appointments cannot be booked on Saturdays.";
        header("Location: book-appointment.php");
        exit;
    }

    // Check if the user has already booked an appointment for the same doctor on the same day
    $stmt = $con->prepare("SELECT * FROM appointment WHERE userId = ? AND doctorId = ? AND appointmentDate = ?");
    $stmt->bind_param("iis", $userid, $doctorid, $appdate);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error_msg'] = "You have already booked an appointment with this doctor on the selected date.";
        $stmt->close();
        header("Location: book-appointment.php");
        exit;
    }

    // Check if the user has already booked an appointment for the same time slot on the same day
    $stmt = $con->prepare("SELECT * FROM appointment WHERE userId = ? AND appointmentDate = ? AND appointmentTime = ?");
    $stmt->bind_param("iss", $userid, $appdate, $time);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error_msg'] = "You have already booked an appointment for this time slot on the selected date.";
        $stmt->close();
        header("Location: book-appointment.php");
        exit;
    }

    // Check if the selected time slot is already taken by another user for the same doctor
  
	
   // Check if the selected time slot is already taken by another user for the same doctor
$stmt = $con->prepare("SELECT * FROM appointment WHERE doctorId = ? AND appointmentDate = ? AND appointmentTime = ?");
$stmt->bind_param("iss", $doctorid, $appdate, $time);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error_msg'] = "This time slot is already booked by another user. Please select a different time.";
    $stmt->close();
    header("Location: book-appointment.php");
    exit;
}

    // Check if the doctor has reached the maximum number of appointments for the day
    $stmt = $con->prepare("SELECT * FROM appointment WHERE doctorId = ? AND appointmentDate = ?");
    $stmt->bind_param("is", $doctorid, $appdate);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows >= 12) {
        $_SESSION['error_msg'] = "No available slots for this doctor on the selected date.";
        $stmt->close();
        header("Location: book-appointment.php");
        exit;
    }

    // Insert the appointment if all checks pass
    $stmt = $con->prepare("INSERT INTO appointment (doctorSpecialization, doctorId, userId, consultancyFees, appointmentDate, appointmentTime, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siisssi", $specilization, $doctorid, $userid, $fees, $appdate, $time, $status);

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Your appointment was successfully booked.";
    } else {
        $_SESSION['error_msg'] = "Error: Could not book the appointment. Please try again.";
    }

    $stmt->close();
    header("Location: appointment-history.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User  | Book Appointment</title>
	
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

		<script>
function getdoctor(val) {
	$.ajax({
	type: "POST",
	url: "get_doctor.php",
	data:'specilizationid='+val,
	success: function(data){
		$("#doctor").html(data);
	}
	});
}
</script>	


<script>
function getfee(val) {
	$.ajax({
	type: "POST",
	url: "get_doctor.php",
	data:'doctor='+val,
	success: function(data){
		$("#fees").html(data);
	}
	});
}
</script>	




	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
			
						<?php include('include/header.php');?>
					
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">User | Book Appointment</h1>
																	</div>
								<ol class="breadcrumb">
									<li>
										<span>User</span>
									</li>
									<li class="active">
										<span>Book Appointment</span>
									</li>
								</ol>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									
									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Book Appointment</h5>
												</div>
												<div class="panel-body">
								<p style="color:red;"><?php echo htmlentities($_SESSION['msg1']);?>
								<?php echo htmlentities($_SESSION['msg1']="");?></p>	
													<form role="form" name="book" method="post" >
														


<div class="form-group">
<p style="color:red;">
    <?php echo htmlentities($_SESSION['error_msg']); ?>
    <?php $_SESSION['error_msg'] = ""; ?> 
</p>
<p style="color:green;">
    <?php echo htmlentities($_SESSION['success_msg']); ?>
    <?php $_SESSION['success_msg'] = ""; ?> 
</p>

															<label for="DoctorSpecialization">
																Doctor Specialization
															</label>
							<select name="Doctorspecialization" class="form-control" onChange="getdoctor(this.value);" required="required">
																<option value="">Select Specialization</option>
<?php $ret=mysqli_query($con,"select * from doctorspecilization");
while($row=mysqli_fetch_array($ret))
{
?>
																<option value="<?php echo htmlentities($row['specilization']);?>">
																	<?php echo htmlentities($row['specilization']);?>
																</option>
																<?php } ?>
																
															</select>
														</div>




														<div class="form-group">
															<label for="doctor">
																Doctors
															</label>
						<select name="doctor" class="form-control" id="doctor" onChange="getfee(this.value);" required="required">
						<option value="">Select Doctor</option>
						</select>
														</div>





														<div class="form-group">
															<label for="consultancyfees">
																Consultancy Fees
															</label>
					<select name="fees" class="form-control" id="fees"  readonly>
						
						</select>
														</div>
														
<div class="form-group">
															<label for="AppointmentDate">
																Date
															</label>

<input class="form-control datepicker" name="appdate"  required="required" data-date-format="yyyy-mm-dd">
	
														</div>
														<div class="form-group">
    <label for="apptime">Available Time Slots</label>
    <select class="form-control" name="apptime" id="timeSlot" required="required">
        <option value="">Select Time</option>
		<?php
        // Call the generateTimeSlots function
        $timeSlots = generateTimeSlots();
        
        // Loop through each time slot and create options
        foreach ($timeSlots as $time) {
            echo "<option value='$time'>$time</option>";
        }
        ?>
    </select>
</div>




														<button type="submit" name="submit" class="btn btn-o btn-primary">
															Submit
														</button>
													</form>
												</div>
											</div>
										</div>
											
											</div>
										</div>
									
									</div>
								</div>
							
						<!-- end: BASIC EXAMPLE -->
			
					
					
						
						
					
						<!-- end: SELECT BOXES -->
						
					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
		
			<!-- start: SETTINGS -->
	 	
			
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});

			$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
	startDate: '+2d' ,
	 endDate: '+7d'
});
		</script>
		<script>
			function loadAvailableSlots() {
    var doctorId = document.querySelector('select[name="doctor"]').value;
    var appDate = document.querySelector('input[name="appdate"]').value;

    if (doctorId && appDate) {
        $.ajax({
            type: "POST",
            url: "get_available_slots.php",
            data: { doctor: doctorId, date: appDate },
            success: function (data) {
                var availableSlots = JSON.parse(data);
                var timeSlotSelect = $("#timeSlot");
                timeSlotSelect.empty(); // Clear the existing options

                // Append the options to the select dropdown
                availableSlots.forEach(function (slot) {
                    var option = $('<option>', {
                        value: slot.time,
                        text: slot.time,
                        disabled: slot.disabled // Disable the option if the slot is booked
                    });
                    timeSlotSelect.append(option);
                });
            }
        });
    }
}


</script>

		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<!-- <input type="text" id="timepicker1">
		<input type="text" id="timepicker1"> -->

<!-- <script type="text/javascript">
    flatpickr("#timepicker1", {
        enableTime: true,         // Enable time picker
        noCalendar: true,         // Disable the calendar
		dateFormat: "h:i K",     // Use 24-hour time format
        minTime: "11:00",         // Block times before 11:00 AM
        maxTime: "17:00",         // Block times after 5:00 PM
        minuteIncrement: 15,      // Allow selection every 15 minutes
        disable: [
            {
                from: "00:00",  // Disable times before 11:00 AM
                to: "10:59"      // Block from midnight until just before 11:00 AM
            },
            {
                from: "17:01",  // Disable times after 5:00 PM
                to: "23:59"      // Block from just after 5:00 PM until midnight
            }
        ]
    });
</script> -->



		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

	</body>
</html>
