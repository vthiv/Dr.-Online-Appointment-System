<?php
session_start();
require("../connection.php");

// Check if the user is logged in and is an admin
if (isset($_SESSION["user"]) && $_SESSION['usertype'] === '1') {
    // The user is an admin, proceed with displaying the page

    // Check if the appointment ID is provided in the URL
    if (isset($_GET['App_ID'])) {
        $appID = $_GET['App_ID'];

        // Fetch prescription details for the provided appointment ID
        $query = "SELECT p.Pat_ID, d.Doctor_Name, a.App_Date, a.App_Time, p.Pat_Firstname, p.Pat_Lastname, pr.Disease, pr.Allergy, pr.Prescription, a.Apt_ID
                FROM prescription pr
                JOIN patient p ON pr.Pat_ID = p.Pat_ID
                JOIN doctor d ON pr.Doc_ID = d.Doctor_ID
                JOIN appointment a ON pr.App_ID = a.App_ID
                WHERE pr.App_ID = ?";

        $stmt = mysqli_prepare($connection, $query);

        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "i", $appID);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $prescriptionData = mysqli_fetch_assoc($result);

            // Populate form fields with prescription details
            $patientName = $prescriptionData['Pat_Firstname'] . ' ' . $prescriptionData['Pat_Lastname'];
            $doctorName = $prescriptionData['Doctor_Name'];
            $apt_id = $prescriptionData['Apt_ID'];
            $appDate = $prescriptionData['App_Date'];
            $appTime = $prescriptionData['App_Time'];
            $disease = $prescriptionData['Disease'];
            $allergy = $prescriptionData['Allergy'];
            $prescription = $prescriptionData['Prescription'];

        } else {
            // Handle the case where the prescription for the provided appointment ID is not found
            $message = "The prescription for the provided appointment ID is not found";
        }
    } else {
        // Handle the case where the appointment ID is not provided in the URL
        $message ="The appointment ID is not found";
    }

} else {
    header("location: ../index.php"); // Redirect non-admin users to the homepage
    exit();
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
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Admin | Patient Prescription</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

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
                    <a class="nav-link collapsed" href="index_admin.php">
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
                    <a class="nav-link" href="patients_admin.php">
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
            <section class="section dashboard">
                <div class="row">
                    <div class="pagetitle">
                        <h1>Patient</h1>
                    </div>

                    <div class="col-sm-4 col-3">
                        <h6 class="title">Patient Prescription</h6>
                    </div>

                    <div class="col-sm-8 text-right m-b-20">
                        <a href="appointment_admin.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="card border-0 p-4 rounded shadow">
                            <form>
                                <input type="hidden" name="appID" value="<?php echo $appID; ?>" >
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Patient Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="patient_name" value="<?= isset($patientName) ? $patientName : '' ?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Doctor Name</label>
                                            <input class="form-control" type="text" name="doctor_name" value="<?= isset($doctorName) ? $doctorName : '' ?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Appointment ID <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="app_id" value="<?= isset($apt_id) ? $apt_id : '' ?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                            <input name="app_date" id="app_date" type="date" class="flatpicker flatpicker-input form-control" value="<?= isset($appDate) ? $appDate : '' ?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Appointment Time <span class="text-danger">*</span></label>
                                            <input name="app_time" id="app_time" type="time" class="form-control timepicker" value="<?= isset($appTime) ? $appTime : '' ?>"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Disease<span class="text-danger">*</span></label>
                                            <textarea name="disease" id="disease" rows="2" class="form-control" placeholder="Disease :"><?= isset($disease) ? $disease : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Allergy<span class="text-danger">*</span></label>
                                            <textarea name="allergy" id="allergy" rows="2" class="form-control" placeholder="Allergy :"><?= isset($allergy) ? $allergy : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Prescription<span class="text-danger">*</span></label>
                                            <textarea name="prescription" id="prescription" rows="2" class="form-control" placeholder="Prescription :"><?= isset($prescription) ? $prescription : '' ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        <script type="text/javascript">
            <?php
                if(isset($message)) {
                    echo 'swal("' . $message . '");';
                } 
            ?>
        </script>
    </body>
</html>