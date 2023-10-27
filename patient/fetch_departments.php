<?php
// fetch_departments.php

// Assuming you have a database connection established already
require("../connection.php");

if(isset($_POST['doctorId'])) {
    $doctorId = $_POST['doctorId'];

    // Fetch departments based on the selected doctor ID
    $departmentQuery = "SELECT dept.Dept_ID, dept.Dept_Name FROM doctor doc 
                        INNER JOIN department dept ON doc.Dept_ID = dept.Dept_ID 
                        WHERE doc.Doctor_ID = '$doctorId'";
    $departmentResult = mysqli_query($connection, $departmentQuery);

    if ($departmentResult && mysqli_num_rows($departmentResult) > 0) {
        while ($row = mysqli_fetch_assoc($departmentResult)) {
            echo '<option value="' . $row['Dept_ID'] . '">' . $row['Dept_Name'] . '</option>';
        }
    } else {
        echo '<option value="">No departments found</option>';
    }
} else {
    echo '<option value="">Invalid request</option>';
}
?>