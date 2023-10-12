<?php
session_start();
require("../connection.php");

if(isset($_SESSION["user"])){
    if(($_SESSION["user"]) == "" or $_SESSION['usertype']!='1'){
        header("location: ../index.php");
    }
} else {
    header('Location:../index.php');  // Redirecting To Home Page
}

// Retrieve the admin's name
$adminEmail = $_SESSION["user"]; // Assuming you store the admin's email in the session
$query = "SELECT `Admin_Name` FROM `admin` WHERE `Admin_Email` = '$adminEmail'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $adminData = mysqli_fetch_assoc($result);
    $adminName = $adminData['Admin_Name'];
} else {
    $adminName = "Admin"; // Default name if not found
}

// Execute SQL queries to get the data
$queryAppointments = "SELECT COUNT(*) AS totalAppointments FROM appointment WHERE App_Status = 1";
$queryNewPatients = "SELECT COUNT(*) AS totalNewPatients FROM patient WHERE Created_At >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
$queryTotalDoctors = "SELECT COUNT(*) AS totalDoctors FROM doctor";

$resultAppointments = mysqli_query($connection, $queryAppointments);
$resultNewPatients = mysqli_query($connection, $queryNewPatients);
$resultTotalDoctors = mysqli_query($connection, $queryTotalDoctors);

if ($resultAppointments && $resultNewPatients && $resultTotalDoctors) {
    $dataAppointments = mysqli_fetch_assoc($resultAppointments);
    $dataNewPatients = mysqli_fetch_assoc($resultNewPatients);
    $dataTotalDoctors = mysqli_fetch_assoc($resultTotalDoctors);

    $totalAppointments = $dataAppointments['totalAppointments'];
    $totalNewPatients = $dataNewPatients['totalNewPatients'];
    $totalDoctors = $dataTotalDoctors['totalDoctors'];
} else {
    // Handle database query errors here
}


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Admin | Dashboard</title>

        <!--Favicons-->
        <link rel="apple-touch-icon" sizes="180x180" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="shortcut icon" type="image/x-icon" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="manifest" href="js/manifest.json">
        <meta name="msapplication-TileImage" content="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <meta name="theme-color" content="#ffffff">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!--Stylesheets-->
        <link href="../css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
        <link href="../css/admin_dashboard.css" rel="stylesheet" />
        <link href="../css/simplebar.css" rel="stylesheet" />
        <link href="../css/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">


    </head>

    <body>

        <!-- ======= Header Starts ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="d-flex align-items-center justify-content-between">
                <a class="logo d-flex align-items-center" href="../index.php">
                    <img src="../img/DR._ONLINE_APPOINTMENT_SYSTEM__LOGO.png" />
                </a>
                
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="list-inline-item mb-0 ms-1">
                        <a href="../logout.php" class="btn btn-icon btn-pills btn-soft-primary">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </header>
        <!-- ======= Header Ends ======= -->

        <!-- ======= Sidebar Starts ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">
                <div class="avatar-profile">
                    <div class="text-center avatar-profile margin-nagative mt-n5 position-relative pb-2 border-0">
                        <img src="../img/admin.jpg" class="rounded-circle shadow-md avatar avatar-md-md" />
                        <h5 class="mt-3 mb-1"><?php echo $adminName; ?></h5>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="index_admin.php">
                        <i class="bi bi-cast"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="departments_admin.php">
                        <i class="bi bi-diagram-2"></i>
                        <span>Department</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="schedule_admin.php">
                        <i class="bi bi-calendar3"></i>
                        <span>Schedule</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="appointment_admin.php">
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Appointment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="doctors_admin.php">
                        <i class="bi bi-heart-pulse"></i>
                        <span>Doctors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="patients_admin.php">
                        <i class="bi bi-people"></i>
                        <span>Patients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="profile_admin.php">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- ======= Sidebar Ends ======= -->

        <!-- ======= Main Starts ======= -->
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Dashboard</h1>
            </div>

            <section class="section dashboard">
                <div class="row">

                    <!-- Left side columns -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!--No of Appointment Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card appointment-card">
                                    <div class="card-body">
                                        <h5 class="card-title">New Appointments</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-calendar-check-fill"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0"><?php echo $totalAppointments; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--No of Appointment Card Ends -->

                            <!--No of Patients Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card patient-card">
                                    <div class="card-body">
                                        <h5 class="card-title">New Patients</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0"><?php echo $totalNewPatients; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--No of Patients Card Ends -->

                            <!--No of Appointment Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card doctor-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Doctors</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-heart-pulse"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0"><?php echo $totalDoctors; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--No of Appointment Card Ends -->

                            <!--Appointment Table -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Appointment List
                                            <a href="appointment_admin.php" style="float: right;"><i class="bi bi-grid"></i></a>
                                        </h4>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table mb-0 new-patient-table">
                                                <thead>
                                                    <tr>
                                                        <th>Appointment ID</th>
                                                        <th>Patient Name</th>
                                                        <th>Doctor Name</th>
                                                        <th>Appointment Date</th>
                                                        <th>Appointment Time</th>
                                                        <th>Appointment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Execute SQL query to get appointment data
                                                    $queryAppointmentsData = "SELECT
                                                        appointment.App_ID,
                                                        CONCAT(patient.Pat_Firstname, ' ', patient.Pat_Lastname) AS patient_name,
                                                        doctor.Doctor_Name,
                                                        appointment.App_Date,
                                                        appointment.App_Time,
                                                        appointment.App_Status
                                                    FROM
                                                        appointment
                                                    INNER JOIN
                                                        patient ON appointment.Pat_ID = patient.Pat_ID
                                                    INNER JOIN
                                                        doctor ON appointment.Doctor_ID = doctor.Doctor_ID
                                                    WHERE
                                                        appointment.App_Status = 1"; // Assuming 1 is for active appointments

                                                    $resultAppointmentsData = mysqli_query($connection, $queryAppointmentsData);

                                                    if ($resultAppointmentsData && mysqli_num_rows($resultAppointmentsData) > 0) {
                                                        // Loop through the appointment data and display it in the table
                                                        while ($row = mysqli_fetch_assoc($resultAppointmentsData)) {
                                                            echo '<tr>';
                                                            echo '<td>' . $row['App_ID'] . '</td>';
                                                            echo '<td>' . $row['patient_name'] . '</td>';
                                                            echo '<td>' . $row['Doctor_Name'] . '</td>';
                                                            echo '<td>' . $row['App_Date'] . '</td>';
                                                            echo '<td>' . $row['App_Time'] . '</td>';
                                                            echo '<td>' . ($row['App_Status'] == 1 ? 'Active' : 'Inactive') . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        echo '<tr><td colspan="6">No appointments found.</td></tr>';
                                                    } 
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Appointment Table Ends -->
                        </div>
                    </div>
                    <!-- End Left side columns -->

                    <!-- Right side columns -->
                    <div class="col-lg-4">
                            <div class="card member-panel">
                                <div class="card-header bg-white">
                                    <h4 class="card-title">Doctors
                                        <a href="doctors_admin.php" style="float: right;"><i class="bi bi-grid"></i></a>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <ul class="contact-list">
                                        <?php
                                            // Execute SQL query to get doctor data (name, department, profile image)
                                            $queryDoctorsData = "SELECT doctor.Doctor_Name, department.Dept_Name FROM doctor
                                                                INNER JOIN department ON doctor.Dept_ID = department.Dept_ID";

                                            $resultDoctorsData = mysqli_query($connection, $queryDoctorsData);

                                            
                                            

                                            if ($resultDoctorsData && mysqli_num_rows($resultDoctorsData) > 0) {
                                                while ($doctorData = mysqli_fetch_assoc($resultDoctorsData)) {
                                                    $doctorName = $doctorData['Doctor_Name'];
                                                    $deptName = $doctorData['Dept_Name'];
                                                    // Generate the image source based on the doctor's name
                                                    $profileImage = strtolower(str_replace(' ', '_', $doctorName)) . '.jpg'; // Assumes lowercase and underscores in filenames
                                                    
                                                    // Generate HTML for each doctor
                                                    echo '<li>';
                                                    echo '<div class="contact-cont d-flex align-items-center">';
                                                    echo '<div class="float-left user-img m-r-5" style="margin-right: 5px;">';
                                                    echo '<a href="#"><img src="../img/doctors/' . $profileImage . '" class="w-40 rounded-circle" style="max-width: 40px; max-height: 40px;"/></a>';
                                                    echo '</div>';
                                                    echo '<div class="contact-info">';
                                                    echo '<span class="contact-name text-ellipsis">' . $doctorName . '</span>';
                                                    echo '<span class="contact-date">' . $deptName . '</span>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</li>';
                                                }
                                            } else {
                                                echo '<li>No doctors found.</li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                    </div>
                    <!-- End Right side columns -->
                </div>
            </section>
        </main>
        <!-- ======= Main Ends ======= -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                <script>document.write(new Date().getFullYear())</script> &copy; Dr Online Appointment.
            </div>
            <div class="credits">
                Design by Thivyah Vijayan.
            </div>
        </footer>
        <!-- ======= Footer Ends ======= -->

        <script src="../js/simplebar.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/select2.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        

    </body>
</html>