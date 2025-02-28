<?php
session_start();
error_reporting(0);
include('include/config.php');

// Redirect if the session ID is not set.
if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit();
}

// Function to check the current status of the appointment
function getAppointmentStatus($appointmentId) {
    global $con;
    $sql = "SELECT status FROM appointment WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $appointmentId);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
    return $status;
}

// Approve appointment
if (isset($_GET['approve_id'])) {
    $id = intval($_GET['approve_id']);
    // Check if the appointment is still Pending before approving
    $currentStatus = getAppointmentStatus($id);
    
    if ($currentStatus == 'Pending') {
        $sql = "UPDATE appointment SET status='Completed' WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Appointment approved successfully!";
        } else {
            $_SESSION['msg'] = "Failed to approve the appointment!";
        }
        $stmt->close();
    } else {
        $_SESSION['msg'] = "Appointment cannot be approved as its current status is '$currentStatus'.";
    }

    header('location:appointment-history.php');
    exit();
}

// Cancel appointment
if (isset($_GET['cancel_id'])) {
    $id = intval($_GET['cancel_id']);
    // Check if the appointment is still Pending before cancelling
    $currentStatus = getAppointmentStatus($id);
    
    if ($currentStatus == 'Pending') {
        $sql = "UPDATE appointment SET status='Cancelled' WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Appointment cancelled successfully!";
        } else {
            $_SESSION['msg'] = "Failed to cancel the appointment!";
        }
        $stmt->close();
    } else {
        $_SESSION['msg'] = "Appointment cannot be cancelled as its current status is '$currentStatus'.";
    }

    header('location:appointment-history.php');
    exit();
}

// Update Visit Status
if (isset($_POST['visit_status']) && isset($_POST['appointment_id'])) {
    $appointmentId = intval($_POST['appointment_id']);
    $visitStatus = $_POST['visit_status'];

    // Check if the appointment is 'Completed' before updating visit status
    $currentStatus = getAppointmentStatus($appointmentId);
    
    if ($currentStatus == 'Completed') {
        $sql = "UPDATE appointment SET visitStatus=? WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('si', $visitStatus, $appointmentId);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Visit status updated to '$visitStatus' successfully!";
        } else {
            $_SESSION['msg'] = "Failed to update visit status!";
        }
        $stmt->close();
    } else {
        $_SESSION['msg'] = "Visit status can only be updated for appointments that are 'Completed'.";
    }

    header('location:appointment-history.php'); // Refresh the page
    exit();
}

?>


<!DOCTYPE

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Appointment History</title>
    <!-- Styles -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="vendor/select2/select2.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color">
</head>
<body><div id="app">
    <?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>
        <div class="main-content">
            <div class="wrap-content container" id="container">
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Doctor | Appointment History</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Doctor</span></li>
                            <li class="active"><span>Appointment History</span></li>
                        </ol>
                    </div>
                </section>
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="color:red;"><?php echo htmlspecialchars($_SESSION['msg']); $_SESSION['msg'] = ""; ?></p>
							<table class="table table-hover" id="sample-table-1">
    <thead>
        <tr>
            <th class="center">#</th>
            <th class="hidden-xs">Patient Name</th>
            <th>Specialization</th>
            <th>Consultancy Fee</th>
            <th>Appointment Date / Time</th>
            <th>Appointment Creation Date</th>
            <th>Appointment Status</th>
            <th>Visit Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch appointments for the logged-in doctor
        $sql = "SELECT users.fullName AS fname, appointment.* FROM appointment JOIN users ON users.id = appointment.userId WHERE appointment.doctorId = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $cnt = 1;

        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td class="center"><?php echo $cnt++; ?>.</td>
                <td class="hidden-xs"><?php echo htmlspecialchars($row['fname']); ?></td>
                <td><?php echo htmlspecialchars($row['doctorSpecialization']); ?></td>
                <td><?php echo htmlspecialchars($row['consultancyFees']); ?></td>
                <td><?php echo htmlspecialchars($row['appointmentDate']); ?> / <?php echo htmlspecialchars($row['appointmentTime']); ?></td>
                <td><?php echo htmlspecialchars($row['postingDate']); ?></td>

                <td>
                    <!-- Display appointment status and buttons -->
                    <?php if ($row['status'] == 'Pending') { ?>
                        <!-- If the appointment is pending, show Approve and Cancel buttons -->
                        <a href="?approve_id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                        <a href="?cancel_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                    <?php } elseif ($row['status'] == 'Completed') { ?>
                        <!-- If the appointment is completed, show Visit Status buttons -->
                        <form action="" method="POST" style="display:inline-block;">
                            <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>" />
                            <button type="submit" name="visit_status" value="Visited" class="btn btn-info btn-sm <?php echo ($row['visitStatus'] == 'Visited') ? 'disabled' : ''; ?>">Visited</button>
                            <button type="submit" name="visit_status" value="Not Visited" class="btn btn-warning btn-sm <?php echo ($row['visitStatus'] == 'Not Visited') ? 'disabled' : ''; ?>">Not Visited</button>
                        </form>
                    <?php } else { ?>
                        <!-- If the appointment is cancelled, display the status as a badge -->
                        <span class="badge badge-danger">Cancelled</span>
                    <?php } ?>
                </td>

                <td>
                    <!-- Display visit status based on the appointment status -->
                    <?php if ($row['status'] == 'Pending') { ?>
                        <span class="badge badge-warning">Pending</span>
                    <?php } elseif ($row['status'] == 'Completed') { ?>
                        <!-- If the appointment is completed, show the current visit status -->
                        <?php if ($row['visitStatus'] == 'Visited' || $row['visitStatus'] == 'Not Visited') { ?>
                            <span class="badge badge-<?php echo ($row['visitStatus'] == 'Visited') ? 'success' : 'danger'; ?>">
                                <?php echo $row['visitStatus']; ?>
                            </span>
                        <?php } else { ?>
                            <!-- If visitStatus is not set yet, show the buttons to set it -->
                            <form action="" method="POST" style="display:inline-block;">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>" />
                                <button type="submit" name="visit_status" value="Visited" class="btn btn-info btn-sm <?php echo ($row['visitStatus'] != '') ? 'disabled' : ''; ?>">Visited</button>
                                <button type="submit" name="visit_status" value="Not Visited" class="btn btn-warning btn-sm <?php echo ($row['visitStatus'] != '') ? 'disabled' : ''; ?>">Not Visited</button>
                            </form>
                        <?php } ?>
                    <?php } else { ?>
                        <!-- If the appointment is cancelled, display the status as Cancelled -->
                        <span class="badge badge-danger">Appointment Cancelled</span>
                    <?php } ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
		
			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>
			
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
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
