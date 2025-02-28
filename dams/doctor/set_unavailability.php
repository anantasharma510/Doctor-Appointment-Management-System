<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorId = $_SESSION['id'];
    $unavailableDate = $_POST['unavailableDate'];
    $weekNumber = date('W', strtotime($unavailableDate));
    $year = date('Y', strtotime($unavailableDate));
    $dayOfWeek = date('N', strtotime($unavailableDate)); // 1 = Monday, 7 = Sunday

    if ($dayOfWeek == 6) {
        $_SESSION['error_msg'] = "Saturdays cannot be marked as unavailable.";
    } else {
        // Count unavailable dates for the same week (Monday–Friday)
        $stmt = $con->prepare("SELECT COUNT(*) FROM doctor_unavailable_dates 
            WHERE doctorId = ? 
            AND YEAR(unavailableDate) = ? 
            AND WEEK(unavailableDate, 1) = ? 
            AND WEEKDAY(unavailableDate) < 5");
        $stmt->bind_param("iii", $doctorId, $year, $weekNumber);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count >= 1) {
            $_SESSION['error_msg'] = "You can only select up to 2 unavailable dates per week (Monday–Friday).";
        } else {
            // Check if the date is already selected
            $stmt = $con->prepare("SELECT COUNT(*) FROM doctor_unavailable_dates WHERE doctorId = ? AND unavailableDate = ?");
            $stmt->bind_param("is", $doctorId, $unavailableDate);
            $stmt->execute();
            $stmt->bind_result($existingCount);
            $stmt->fetch();
            $stmt->close();

            if ($existingCount > 0) {
                $_SESSION['error_msg'] = "This date is already marked as unavailable.";
            } else {
                // Insert the unavailable date
                $stmt = $con->prepare("INSERT INTO doctor_unavailable_dates (doctorId, unavailableDate) VALUES (?, ?)");
                $stmt->bind_param("is", $doctorId, $unavailableDate);

                if ($stmt->execute()) {
                    $_SESSION['success_msg'] = "The date has been marked as unavailable.";
                } else {
                    $_SESSION['error_msg'] = "Failed to mark the date as unavailable.";
                }
                $stmt->close();
            }
        }
    }

    header("Location: set_unavailability.php");
    exit();
}

// Fetch unavailable dates
$doctorId = $_SESSION['id'];
$query = "SELECT unavailableDate FROM doctor_unavailable_dates WHERE doctorId = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$result = $stmt->get_result();
$unavailableDates = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

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

<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/styles.css">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="container">
    <br>
    <h2>Set Unavailability</h2>

    <!-- Success or Error Messages -->
    <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
        </div>
    <?php elseif (isset($_SESSION['error_msg'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
        </div>
    <?php endif; ?>

    <!-- Form to set unavailability -->
    <form method="POST" action="set_unavailability.php" class="form-inline">
        <div class="form-group mb-3">
            <label for="unavailableDate" class="form-label">Select Unavailable Date</label>
            <input type="text" id="unavailableDate" name="unavailableDate" class="form-control mx-2" required>
        </div>
        <button type="submit" class="btn btn-primary">Set Unavailable Date</button>
    </form>

    <!-- Display Unavailability Records -->
    <div class="container mt-4">
    <h3>Previous Unavailability Dates:</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Unavailable Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($unavailableDates)): ?>
                    <?php foreach ($unavailableDates as $date): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($date['unavailableDate']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td class="text-center">No unavailability records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<?php include('include/footer.php'); ?>

<!-- Scripts -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>

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
   
</script>
<script>
    $(document).ready(function() {
        $('#unavailableDate').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '+4d',
            autoclose: true,
            todayHighlight: true,
            daysOfWeekDisabled: "6" // Disable Saturdays
        });

        // AJAX validation to check date before submission
        $("#unavailableDate").on("change", function() {
            var selectedDate = $(this).val();
            $.post("", { unavailableDate: selectedDate }, function(response) {
                if (response.error) {
                    alert(response.message);
                    $("#unavailableDate").val(""); // Clear selection if invalid
                }
            }, "json");
        });
    });
</script>
<script>
    const unavailableDates = <?php echo json_encode($unavailableDates); ?>;
    console.log("Doctor's Unavailable Dates:", unavailableDates);
</script>
