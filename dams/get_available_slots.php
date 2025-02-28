<?php
include('include/config.php');

if (isset($_POST['doctor']) && isset($_POST['date'])) {
    $doctorId = $_POST['doctor'];
    $appDate = $_POST['date'];

    // Fetch booked time slots
    $query = $mysqli->prepare("SELECT appointmentTime FROM appointment WHERE doctorId = ? AND appointmentDate = ?");
    $query->bind_param("is", $doctorId, $appDate);
    $query->execute();
    $query->bind_result($bookedTime);

    $bookedSlots = [];
    while ($query->fetch()) {
        $bookedSlots[] = $bookedTime;
    }
    $query->close();

    // Generate all time slots
    $start = strtotime("11:00");
    $end = strtotime("17:00");
    $timeSlots = [];

    while ($start < $end) {
        $slot = date("h:i A", $start);
        $disabled = in_array($slot, $bookedSlots) ? "disabled" : ""; // Disable booked slots
        $timeSlots[] = ['time' => $slot, 'disabled' => $disabled];
        $start = strtotime("+30 minutes", $start);
    }

    // Return time slots as JSON
    echo json_encode($timeSlots);
}
?>
