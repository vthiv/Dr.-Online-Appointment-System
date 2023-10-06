<?php
session_start();
require("../connection.php");

if(isset($_SESSION["user"])){
    if(($_SESSION["user"]) == "" or $_SESSION['usertype']!='2'){
        header("location: ../index.php");
    }
} else {
    header('Location:../index.php');  // Redirecting To Home Page
}

//Retrieve the doctor's name
$doctorEmail = $_SESSION["user"]; //Assuming store the doctor's email in the session
$query = "SELECT `Doctor_Name`, `Dept_ID` FROM `doctor` WHERE `Email` = '$doctorEmail'";
$result=mysqli_query($connection,$query);

if ($result && mysqli_num_rows($result) > 0) {
    $doctorData = mysqli_fetch_assoc($result);
    $doctorName = $doctorData['Doctor_Name'];
    $deptID = $doctorData['Dept_ID'];

    // Fetch the department name based on the department ID
    $deptQuery = "SELECT `Dept_Name` FROM `department` WHERE `Dept_ID` = $deptID";
    $deptResult = mysqli_query($connection, $deptQuery);

    if ($deptResult && mysqli_num_rows($deptResult) > 0) {
        $deptData = mysqli_fetch_assoc($deptResult);
        $departmentName = $deptData['Dept_Name'];
    }
    else {
        $departmentName = "Unknown Department"; // Default if department not found
    }
}
else {
    $doctorName = "Doctor"; // Default name if not found
    $departmentName = "Unknown Department"; // Default department if not found
}

// Generate the image source based on the doctor's name
$profileImage = strtolower(str_replace(' ', '_', $doctorName)) . '.jpg'; // Assumes lowercase and underscores in filenames

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Doctor | Dashboard</title>

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
                        <img src="../img/doctors/<?php echo $profileImage; ?>" class="rounded-circle shadow-md avatar avatar-md-md" />
                        <h5 class="mt-3 mb-1"><?php echo $doctorName; ?></h5>
                        <p class="text-muted mb-0">Doctor <?php echo $departmentName; ?></p>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="index_doctor.php">
                        <i class="bi bi-cast"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="departments_doctor.php">
                        <i class="bi bi-diagram-2"></i>
                        <span>Department</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="schedule_doctor.php">
                        <i class="bi bi-calendar3"></i>
                        <span>Schedule</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="appointment_doctor.php">
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Appointment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="doctors.php">
                        <i class="bi bi-heart-pulse"></i>
                        <span>Doctors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="patients_doctor.php">
                        <i class="bi bi-people"></i>
                        <span>Patients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="profile_doctor.php">
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
                                                <h5 class="mb-0">Data</h5>
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
                                                <h5 class="mb-0">Data</h5>
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
                                                <h5 class="mb-0">Data</h5>
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
                                                    <tr>
                                                        <td>Appointment ID</td>
                                                        <td>Patient Name</td>
                                                        <td>Doctor Name</td>
                                                        <td>Appointment Date</td>
                                                        <td>Appointment Time</td>
                                                        <td>Appointment Status</td>
                                                    </tr>
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
                                        <li>
                                            <div class="contact-cont">
                                                <div class="float-left user-img m-r-10">
                                                    <a href="#"><img src="#" class="w-40 rounded-circle"/></a>
                                                </div>
                                                <div class="contact-info">
                                                    <span class="contact-name text-ellipsis">Name</span>
                                                    <span class="contact-date">Speciality</span>
                                                </div>
                                            </div>
                                        </li>
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