<?php
// fetch_patient_details.php

if (isset($_POST['pat_id'])) {
    require("../connection.php");

    $patientID = mysqli_real_escape_string($connection, $_POST['pat_id']);

    $fetchPatientQuery = "SELECT `Pat_Email`, `Pat_PhoneNo` FROM `patient` WHERE `Pat_ID` = '$patientID'";
    $fetchPatientResult = mysqli_query($connection, $fetchPatientQuery);

    if ($fetchPatientResult && mysqli_num_rows($fetchPatientResult) > 0) {
        $patientDetails = mysqli_fetch_assoc($fetchPatientResult);
        echo json_encode($patientDetails);
    } else {
        echo json_encode(['error' => 'Patient details not found.']);
    }
} else {
    echo json_encode(['error' => 'Patient ID not provided.']);
}
?>