<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {

	if (isset($_POST['submit'])) {
		$docid = $_SESSION['id'];
		$patname = $_POST['patname'];
		$patcontact = $_POST['patcontact'];
		$patemail = $_POST['patemail'];
		$gender = $_POST['gender'];
		$pataddress = $_POST['pataddress'];
		$patage = $_POST['patage'];
		$medhis = $_POST['medhis'];
	
		// Check for duplicate patient under the same doctor
		$checkQuery = mysqli_query($con, "SELECT * FROM tblpatient WHERE PatientEmail = '$patemail' AND Docid = '$docid'");
		if (mysqli_num_rows($checkQuery) > 0) {
			echo "<script>alert('This patient is already added under this doctor.');</script>";
		} else {
			// Insert new patient record
			$sql = mysqli_query($con, "INSERT INTO tblpatient (Docid, PatientName, PatientContno, PatientEmail, PatientGender, PatientAdd, PatientAge, PatientMedhis) 
			VALUES ('$docid', '$patname', '$patcontact', '$patemail', '$gender', '$pataddress', '$patage', '$medhis')");
	
			if ($sql) {
				echo "<script>alert('Patient info added successfully');</script>";
				echo "<script>window.location.href ='manage-patient.php'</script>";
			} else {
				echo "<script>alert('Something went wrong. Please try again.');</script>";
			}
		}
	}
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Add Patient</title>

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

    <script>
function userAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: {
            email: $("#patemail").val(),
            docid: "<?php echo $_SESSION['id']; ?>"
        },
        type: "POST",
        success: function(data) {
            $("#user-availability-status1").html(data);
            $("#loaderIcon").hide();
        },
        error: function() {}
    });
}

function fetchPatientDetails(patientId) {
    if(patientId) {
        jQuery.ajax({
            url: "get_patient_details.php",
            data: { patientId: patientId },
            type: "POST",
            success: function(response) {
                const data = JSON.parse(response);
                if(data) {
                    $("input[name='patname']").val(data.fullName);
                    $("input[name='patcontact']").val(data.phone);
                    $("input[name='patemail']").val(data.email);
                    $("input[name='gender'][value='" + data.gender + "']").prop("checked", true);
                    $("textarea[name='pataddress']").val(data.address);
                    $("input[name='patage']").val(data.age);
                    $("textarea[name='medhis']").val(data.medhis);
                }
            },
            error: function() {
                alert('Failed to fetch patient details.');
            }
        });
    }
}
</script>
</head>
<body>
<div id="app">
    <?php include('include/sidebar.php');?>
    <div class="app-content">
        <?php include('include/header.php');?>
        <div class="main-content">
            <div class="wrap-content container" id="container">
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Patient | Add Patient</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Patient</span></li>
                            <li class="active"><span>Add Patient</span></li>
                        </ol>
                    </div>
                </section>
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row margin-top-30">
                                <div class="col-lg-8 col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">Add Patient</h5>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" name="" method="post">
											<div class="form-group">
    <label for="visitedPatient">Select User</label>
    <select name="visitedPatient" class="form-control" onchange="fetchPatientDetails(this.value)">
        <option value="">Select User</option>
        <?php
        // Join 'users' and 'appointment' tables to get users with 'visitStatus' = 'Visited'
        $query = mysqli_query($con, "
            SELECT DISTINCT u.id, u.fullName 
            FROM users u 
            INNER JOIN appointment a ON u.id = a.userId 
            WHERE a.visitStatus = 'Visited'
        ");
        while ($row = mysqli_fetch_array($query)) {
            echo '<option value="'.$row['id'].'">'.$row['fullName'].'</option>';
        }
        ?>
    </select>
</div>

                                                <div class="form-group">
                                                    <label for="doctorname">Patient Name</label>
                                                    <input type="text" name="patname" class="form-control" placeholder="Enter Patient Name" required="true">
                                                </div>
                                                <div class="form-group">
                                                    <label for="fess">Patient Contact no</label>
                                                    <input type="text" name="patcontact" class="form-control" placeholder="Enter Patient Contact no" required="true" maxlength="10" pattern="[0-9]+">
                                                </div>
                                                <div class="form-group">
                                                    <label for="fess">Patient Email</label>
                                                    <input type="email" id="patemail" name="patemail" class="form-control" placeholder="Enter Patient Email id" required="true" onBlur="userAvailability()">
                                                    <span id="user-availability-status1" style="font-size:12px;"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="block">Gender</label>
                                                    <div class="clip-radio radio-primary">
                                                        <input type="radio" id="rg-female" name="gender" value="female">
                                                        <label for="rg-female">Female</label>
                                                        <input type="radio" id="rg-male" name="gender" value="male">
                                                        <label for="rg-male">Male</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Patient Address</label>
                                                    <textarea name="pataddress" class="form-control" placeholder="Enter Patient Address" required="true"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fess">Patient Age</label>
                                                    <input type="text" name="patage" class="form-control" placeholder="Enter Patient Age" required="true">
                                                </div>
                                                <div class="form-group">
                                                    <label for="fess">Medical History</label>
                                                    <textarea type="text" name="medhis" class="form-control" placeholder="Enter Patient Medical History(if any)" required="true"></textarea>
                                                </div>
                                                <button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('include/footer.php');?>
    <?php include('include/setting.php');?>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/autosize/autosize.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        FormElements.init();
    });
</script>
</body>
</html>
<?php } ?>
