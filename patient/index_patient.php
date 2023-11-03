<?php
session_start();
require("../connection.php");

if(isset($_SESSION["user"])){
    if(($_SESSION["user"]) == "" or $_SESSION['usertype']!='3'){
        header("location: ../index.php");
    }
} else {
    header('Location:../index.php');  // Redirecting To Home Page
}

//Retrieve the doctor's name
$patientEmail = $_SESSION["user"]; // Assuming store the patient's email in the session
$query = "SELECT CONCAT(Pat_Firstname, ' ', Pat_Lastname) AS patient_name, Pat_ID FROM `patient` WHERE `Pat_Email` = '$patientEmail'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $patientData = mysqli_fetch_assoc($result);
    $patientID = $patientData['Pat_ID'];
    $patientName = $patientData['patient_name'];
}
else {
    $patientName = "Patient" ; // Default name if not found
}

$queryTotalDoctors = "SELECT COUNT(*) AS totalDoctors FROM doctor";
$queryTotalAppointments = "SELECT COUNT(*) AS totalAppointments FROM appointment WHERE Pat_ID = $patientID";
$today = date('Y-m-d');
$queryTodayAppointments = "SELECT COUNT(*) AS todayApp FROM appointment a INNER JOIN doctor d ON a.Doctor_ID = d.Doctor_ID WHERE Pat_ID = $patientID AND App_Date = '$today'";

$resultTotalDoctors = mysqli_query($connection, $queryTotalDoctors);
$resultTotalAppointments = mysqli_query($connection, $queryTotalAppointments);
$resultTodayAppointments = mysqli_query($connection, $queryTodayAppointments);

if ($resultTotalDoctors && $resultTotalAppointments && $resultTodayAppointments) {

    $dataTotalDoctors = mysqli_fetch_assoc($resultTotalDoctors);
    $dataTotalAppointments = mysqli_fetch_assoc($resultTotalAppointments);
    $dataTodayAppointments = mysqli_fetch_assoc($resultTodayAppointments);

    $totalDoctors = $dataTotalDoctors['totalDoctors'];
    $totalAppointments = $dataTotalAppointments['totalAppointments'];
    $todaysAppointment = $dataTodayAppointments['todayApp'];

} else {
    // Handle database query errors here
    $totalDoctors = 0;
    $totalAppointments = 0;
    $todaysAppointment = "<p style='font-size: small;'>No appointments for today</p>";
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Patient | Dashboard</title>

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
                        <h5 class="mt-3 mb-1"><?php echo $patientName; ?></h5>
                        <p class="text-muted mb-0"><?php echo $patientEmail; ?></p>
                        <p class="text-muted mb-0">Patient</p>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="index_patient.php">
                        <i class="bi bi-cast"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="appointment_patient.php">
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Appointment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="doctors_patient.php">
                        <i class="bi bi-heart-pulse"></i>
                        <span>Doctors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="profile_patient.php">
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
                            <!--No of Doctors Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card appointment-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Doctor</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-heart-pulse"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h2 class="mb-0"><?php echo $totalDoctors; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--No of Doctor Card Ends -->

                            <!--No of Appointment Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card patient-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Appointment </h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-calendar-plus-fill"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h2 class="mb-0"><?php echo $totalAppointments; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--No of Appointment Card Ends -->

                            <!--No of Schedule Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card doctor-card">
                                    <div class="card-body">
                                        <h6 class="card-title">Today's Appointment</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-calendar-check-fill"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h2 class="mb-0"><?php echo $todaysAppointment; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--No of Schedule Card Ends -->

                            <!--Appointment Table -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Appointment List
                                            <a href="appointment_patient.php" style="float: right;"><i class="bi bi-grid"></i></a>
                                        </h4>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table mb-0 new-patient-table">
                                                <thead>
                                                    <tr>
                                                        <th>Appointment ID</th>
                                                        <th>Doctor Name</th>
                                                        <th>Appointment Date</th>
                                                        <th>Appointment Time</th>
                                                        <th>Appointment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $queryAppointments = "SELECT a.App_ID, a.Apt_ID, 
                                                                        d.Doctor_Name, a.App_Date, a.App_Time,
                                                                        CASE 
                                                                            WHEN a.App_Status = 1 THEN 'Active'
                                                                            ELSE 'Inactive'
                                                                        END AS appointment_status 
                                                                        FROM appointment a
                                                                        INNER JOIN patient p ON a.Pat_ID = p.Pat_ID 
                                                                        INNER JOIN doctor d ON a.Doctor_ID = d.Doctor_ID 
                                                                        WHERE a.Pat_ID = $patientID";
                                                
                                                    $resultAppointments = mysqli_query($connection, $queryAppointments);

                                                    if ($resultAppointments && mysqli_num_rows($resultAppointments) > 0) {
                                                        while ($row = mysqli_fetch_assoc($resultAppointments)) {
                                                            echo "
                                                                <tr>
                                                                    <td>" . $row['Apt_ID'] . "</td>
                                                                    <td>" . $row['Doctor_Name'] . "</td>
                                                                    <td>" . $row['App_Date'] . "</td>
                                                                    <td>" . $row['App_Time'] . "</td>
                                                                    <td><span class='custom-badge status-" . ($row["appointment_status"] ? "green'>Active" : "red'>Inactive") . "</span></td>
                                                                </tr>";
                                                        }
                                                    } else {
                                                        $appointmentTable = "<tr><td colspan='6'>No appointments found</td></tr>";
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
                                <h4 class="card-title">Today's Appointment</h4>
                            </div>
                            <div class="card-body">
                                <ul class="contact-list">
                                    <?php
                                    $today = date('Y-m-d');
                                    $todayAppointmentquery = "SELECT * 
                                                                FROM appointment a  
                                                                INNER JOIN doctor d 
                                                                ON a.Doctor_ID = d.Doctor_ID 
                                                                INNER JOIN department dept 
                                                                ON a.Dept_ID = dept.Dept_ID
                                                                WHERE Pat_ID = $patientID 
                                                                AND App_Date = '$today'";
                                    $resulttodayAppointment = mysqli_query($connection, $todayAppointmentquery);
                                    if ($resulttodayAppointment && mysqli_num_rows($resulttodayAppointment) > 0) {
                                        while ($row = mysqli_fetch_assoc($resulttodayAppointment)) {
                                            echo 
                                                '<li>
                                                        <div class="contact-info">
                                                        <span class="contact-dept text-ellipsis">Department: ' . $row["Dept_Name"] . '</span>
                                                            <span class="contact-doctorname text-ellipsis">Doctor Name: ' . $row["Doctor_Name"] . '</span>
                                                            <span class="contact-date text-ellipsis">Date: ' . $row["App_Date"] . '</span>
                                                            <span class="contact-time text-ellipsis">Time: ' . $row["App_Time"] . '</span>
                                                        </div>
                                                </li>';
                                        }
                                    } else {
                                        echo '
                                        <div class="card-body">
                                            <p>  No appointments for today</p>
                                        </div>';
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        

    </body>
</html>