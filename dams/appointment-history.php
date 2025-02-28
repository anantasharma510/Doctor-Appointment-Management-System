<?php
session_start();
error_reporting(0);
include('include/config.php');

// Check if the user is logged in
if(strlen($_SESSION['id'])==0) {
    header('location:logout.php');
}

// Handle appointment cancellation
if (isset($_GET['cancel_id'])) {
    $cancelId = intval($_GET['cancel_id']);

    // Check if the appointment status is 'Pending' before allowing cancellation
    $sql = "UPDATE appointment SET status = 'Cancelled' WHERE id = ? AND status = 'Pending'";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $cancelId);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Appointment cancelled successfully!";
    } else {
        $_SESSION['msg'] = "Failed to cancel the appointment!";
    }

    $stmt->close();
    header('location:appointment-history.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User | Appointment History</title>
		
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

	</head>
	<body>
	<div id="app">		 
<?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>
        <!-- end: TOP NAVBAR -->
        <div class="main-content">
            <div class="wrap-content container" id="container">
                <!-- start: PAGE TITLE -->
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">User | Appointment History</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>User</span></li>
                            <li class="active"><span>Appointment History</span></li>
                        </ol>
                    </div>
                </section>
                <!-- end: PAGE TITLE -->
                <!-- start: BASIC EXAMPLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="color:red;"><?php echo htmlentities($_SESSION['msg']); ?>
                            <?php echo htmlentities($_SESSION['msg'] = ""); ?></p>	
                            <table class="table table-hover" id="sample-table-1">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="hidden-xs">Doctor Name</th>
                                        <th>Specialization</th>
                                        <th>Consultancy Fee</th>
                                        <th>Appointment Date / Time</th>
                                        <th>Appointment Creation Date</th>
                                        <th>Current Status</th> <!-- Show status (Pending, Completed, Cancelled) -->
                                        <th>Visit Status</th> <!-- Visit status (Visited, Not Visited, Pending) -->
                                        <th>Action</th> <!-- Action buttons (Cancel, etc.) -->
                                    </tr>
                                </thead>
								<tbody>
<?php
$sql = mysqli_query($con, "SELECT doctors.doctorName AS docname, appointment.* FROM appointment JOIN doctors ON doctors.id = appointment.doctorId WHERE appointment.userId = '".$_SESSION['id']."'");
$cnt = 1;
while ($row = mysqli_fetch_array($sql)) {
?>
    <tr>
        <td class="center"><?php echo $cnt; ?>.</td>
        <td class="hidden-xs"><?php echo $row['docname']; ?></td>
        <td><?php echo $row['doctorSpecialization']; ?></td>
        <td><?php echo $row['consultancyFees']; ?></td>
        <td><?php echo $row['appointmentDate']; ?> / <?php echo $row['appointmentTime']; ?></td>
        <td><?php echo $row['postingDate']; ?></td>
        <td>
            <?php 
            if ($row['status'] == 'Pending') {
                echo "<span class='badge badge-warning'>Pending</span>";
            } elseif ($row['status'] == 'Completed') {
                echo "<span class='badge badge-success'>Completed</span>";
            } elseif ($row['status'] == 'Cancelled') {
                echo "<span class='badge badge-danger'>Cancelled</span>";
            }
            ?>
        </td>
        <td>
            <?php 
            if ($row['visitStatus'] == 'Visited') {
                echo "<span class='badge badge-success'>Visited</span>";
            } elseif ($row['visitStatus'] == 'Not Visited') {
                echo "<span class='badge badge-danger'>Not Visited</span>";
            } else {
                echo "<span class='badge badge-warning'>Pending</span>";
            }
            ?>
        </td>
		<td>
        <td>
    <?php 
    if ($row['status'] == 'Completed') {
        echo "<button 
                class='btn btn-success btn-sm' 
                onclick=\"downloadTicket(
                    '" . htmlspecialchars($row['id']) . "',
                    '" . htmlspecialchars($row['docname']) . "',
                    '" . htmlspecialchars($row['appointmentDate']) . "',
                    '" . htmlspecialchars($row['appointmentTime']) . "'
                )\">Download Ticket</button>";
    }
    ?>
</td>


<script>

async function downloadTicket(appointmentId, doctorName, appointmentDate, appointmentTime) {
    // Ensure all data is available
    if (!appointmentId || !doctorName || !appointmentDate || !appointmentTime) {
        alert("Error: Missing appointment details.");
        return;
    }

    // Import jsPDF
    const { jsPDF } = window.jspdf;

    // Create a new PDF document
    const doc = new jsPDF();

    // Add content to the PDF
    doc.setFont("Helvetica", "bold");
    doc.setFontSize(18);
    doc.text("Appointment Ticket", 105, 20, { align: "center" });

    doc.setFont("Helvetica", "normal");
    doc.setFontSize(12);
    doc.text("Thank you for booking your appointment!", 105, 30, { align: "center" });

    // Add ticket details with a border
    doc.setLineWidth(0.5);
    doc.rect(20, 40, 170, 80); // Rectangular border for ticket details

    // Ticket Details
    doc.setFont("Helvetica", "bold");
    doc.text("Appointment ID:", 25, 50);
    doc.setFont("Helvetica", "normal");
    doc.text(appointmentId, 70, 50);

    doc.setFont("Helvetica", "bold");
    doc.text("Doctor Name:", 25, 60);
    doc.setFont("Helvetica", "normal");
    doc.text(doctorName, 70, 60);

    doc.setFont("Helvetica", "bold");
    doc.text("Date:", 25, 70);
    doc.setFont("Helvetica", "normal");
    doc.text(appointmentDate, 70, 70);

    doc.setFont("Helvetica", "bold");
    doc.text("Time:", 25, 80);
    doc.setFont("Helvetica", "normal");
    doc.text(appointmentTime, 70, 80);

    doc.setFont("Helvetica", "bold");
    doc.text("Note:", 25, 90);
    doc.setFont("Helvetica", "normal");
    doc.text("Please be on time for your appointment.", 70, 90);

    // Add footer
    doc.setFont("Helvetica", "italic");
    doc.setFontSize(10);
    doc.text("Generated by Your Doctor Appointment Management System", 105, 130, { align: "center" });

    // Save the PDF
    doc.save(`Appointment_Ticket_${appointmentId}.pdf`);
}
</script>



</td>

    </tr>
<?php 
$cnt = $cnt + 1;
} ?>
</tbody>

                            </table>
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
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Handle the "Download Ticket" button click
    $(document).on('click', '.download-ticket', function () {
        const appointmentId = $(this).data('id'); // Get appointment ID

        // Make an AJAX call to fetch appointment details
        $.ajax({
            url: 'fetch-appointment.php', // Backend script to fetch appointment details
            type: 'GET',
            data: { appointment_id: appointmentId },
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    // Generate the ticket content
                    const ticketContent = `
                        Appointment Ticket
                        ----------------------------
                        Patient Name: ${data.patientName}
                        Doctor Name: ${data.doctorName}
                        Specialization: ${data.specialization}
                        Appointment Date: ${data.appointmentDate}
                        Appointment Time: ${data.appointmentTime}
                        ----------------------------
                        Thank you for using our service!
                    `;

                    // Create a Blob object for the ticket
                    const blob = new Blob([ticketContent], { type: 'text/plain' });

                    // Create a link to download the ticket
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `Ticket_${data.patientName.replace(/\s+/g, '_')}_ID${appointmentId}.txt`;

                    // Trigger the download
                    link.click();
                } else {
                    alert('Failed to fetch appointment details. Please try again.');
                }
            },
            error: function () {
                alert('Error occurred while fetching appointment details.');
            }
        });
    });
});
</script>

	</body>
</html>
