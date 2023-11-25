<?php
// get_departments.php

require("../connection.php");

if (isset($_POST["doctor_id"])) {
    $doctor_id = $_POST["doctor_id"];
    
    // Query to fetch department options based on the selected doctor
    $departmentQuery = "SELECT dept.Dept_ID, dept.Dept_Name FROM doctor doc 
                        INNER JOIN department dept ON doc.Dept_ID = dept.Dept_ID 
                        WHERE doc.Doctor_ID = '$doctor_id'";

    $departmentResult = mysqli_query($connection, $departmentQuery);

    if ($departmentResult && mysqli_num_rows($departmentResult) > 0) {
        while ($row = mysqli_fetch_assoc($departmentResult)) {
            echo '<option value="' . $row['Dept_ID'] . '">' . $row['Dept_Name'] . '</option>';
        }
    } else {
        echo '<option value="">No departments available</option>';
    }
} else {
    echo '<option value="">Invalid request</option>';
}
?>