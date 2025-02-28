<?php 
require_once("include/config.php");

if (!empty($_POST["email"]) && !empty($_POST["docid"])) {
    $email = $_POST["email"];
    $docid = $_POST["docid"];
    
    $result = mysqli_query($con, "SELECT PatientEmail FROM tblpatient WHERE PatientEmail='$email' AND Docid='$docid'");
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "<span style='color:red'> Email already exists for this doctor.</span>";
        echo "<script>$('#submit').prop('disabled', true);</script>";
    } else {
        echo "<span style='color:green'> Email available for Registration.</span>";
        echo "<script>$('#submit').prop('disabled', false);</script>";
    }
}
?>