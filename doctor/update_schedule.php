<?php
session_start();
require("../connection.php");

if (isset($_POST['update_schedule_btn'])) {
    // Extract the submitted form data
    $scheduleID = $_POST['schedule_id'];
    $scheduleTitle = $_POST['schedule_title'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $scheduleStatus = $_POST['schedule_status'];

    // Update the schedule in the database
    $updateQuery = "UPDATE schedule SET Schedule_Title = '$scheduleTitle', Schedule_StartTime = '$start_time', Schedule_EndTime = '$end_time', Schedule_Status = '$scheduleStatus' WHERE Schedule_ID = $scheduleID";

    if (mysqli_query($connection, $updateQuery)) {
        // Redirect to the schedule page upon successful update
        header("Location: schedule_doctor.php");
    } else {
        // Handle the error in case the update fails
        echo "Error updating schedule: " . mysqli_error($connection);
    }
}
?>
