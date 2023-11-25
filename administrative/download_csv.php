<?php
// Include your database connection and session start here
include("../connection.php");

// Execute SQL query to get the data
$queryAppointmentsPerDept = "SELECT 
                                department.Dept_Name,
                                patient.Pat_Firstname,
                                patient.Pat_Lastname,
                                appointment.App_Date
                            FROM appointment
                            INNER JOIN department ON appointment.Dept_ID = department.Dept_ID
                            INNER JOIN patient ON appointment.Pat_ID = patient.Pat_ID
                            ORDER BY department.Dept_Name";

$resultAppointmentsPerDept = mysqli_query($connection, $queryAppointmentsPerDept);

$appointmentsData = array();

if ($resultAppointmentsPerDept && mysqli_num_rows($resultAppointmentsPerDept) > 0) {
    while ($row = mysqli_fetch_assoc($resultAppointmentsPerDept)) {
        $appointmentsData[] = $row;
    }
}

// Set headers for CSV download
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=Total Appointments per Department.csv');

// Output the CSV content
echo "Department Name,Patient Name,Appointment Date\n";
$currentDepartment = '';
foreach ($appointmentsData as $data) {
    if ($currentDepartment != $data['Dept_Name']) {
        echo '"' . $data['Dept_Name'] . '",';
        $currentDepartment = $data['Dept_Name'];
    } else {
        echo ',';
    }
    
    echo '"' . $data['Pat_Firstname'] . ' ' . $data['Pat_Lastname'] . '","' . $data['App_Date'] . "\"\n";
}
?>
