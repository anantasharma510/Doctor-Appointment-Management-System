<?php
include('include/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['patientId'])) {
    $patientId = intval($_POST['patientId']);

    $query = mysqli_query($con, "SELECT * FROM users WHERE id = '$patientId'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'User not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
