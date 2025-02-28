<?php
include('include/config.php');

if (isset($_GET['appointment_id'])) {
    $appointmentId = intval($_GET['appointment_id']);

    // Fetch appointment details
    $query = $con->prepare("SELECT a.*, u.fullName AS patientName, d.doctorName, d.doctorSpecialization 
                            FROM appointment a
                            JOIN users u ON a.userId = u.id
                            JOIN doctors d ON a.doctorId = d.id
                            WHERE a.id = ?");
    $query->bind_param('i', $appointmentId);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'patientName' => $appointment['patientName'],
            'doctorName' => $appointment['doctorName'],
            'specialization' => $appointment['doctorSpecialization'],
            'appointmentDate' => $appointment['appointmentDate'],
            'appointmentTime' => $appointment['appointmentTime']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
