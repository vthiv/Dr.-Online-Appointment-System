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

//Retrieve the doctor's name
$query = "SELECT `Doctor_ID`, `Doctor_Name`, `Dept_ID`, `Profile_Image` FROM `doctor` WHERE `Email` = '$doctorEmail'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $doctorData = mysqli_fetch_assoc($result);
    $doctorID = $doctorData['Doctor_ID'];
    $doctorName = $doctorData['Doctor_Name'];
    $deptID = $doctorData['Dept_ID'];
    $profileImage = $doctorData['Profile_Image'];

    // Fetch the department name based on the department ID
    $deptQuery = "SELECT `Dept_Name` FROM `department` WHERE `Dept_ID` = $deptID";
    $deptResult = mysqli_query($connection, $deptQuery);

    if ($deptResult && mysqli_num_rows($deptResult) > 0) {
        $deptData = mysqli_fetch_assoc($deptResult);
        $departmentName = $deptData['Dept_Name'];
    } else {
        $departmentName = "Unknown Department"; // Default if department not found
    }
} else {
    $doctorName = "Doctor"; // Default name if not found
    $departmentName = "Unknown Department"; // Default department if not found
    $profileImage = "default.jpg"; // Default image if not found
}

// Retrieve doctors with department details using INNER JOIN
$doctorsQuery = "SELECT d.*, dept.Dept_Name FROM doctor d
                 INNER JOIN department dept ON d.Dept_ID = dept.Dept_ID";
$doctorsResult = mysqli_query($connection, $doctorsQuery);


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Patient | Department</title>

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
                    <a class="nav-link collapsed" href="index_patient.php">
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
                    <a class="nav-link" href="doctors_patient.php">
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
                <h1>Doctors</h1>
            </div>

            <section class="section dashboard">
                <div class="row">
                    <div class="row row-cols-md-2 row-cols-lg-5">
                        <?php
                        if ($doctorsResult && mysqli_num_rows($doctorsResult) > 0) {
                            while ($row = mysqli_fetch_assoc($doctorsResult)) {
                                ?>
                                <div class="col mt-4"> <!-- Each doctor card should be in a separate column -->
                                    <div class="card team border-0 rounded shadow overflow-hidden">
                                        <div class="team-img position-relative">
                                            <?php
                                            if (!empty($row['Profile_Image'])) {
                                                // Construct the image source directly from the profile image filename
                                                $profileImageSrc = "../img/doctors/" . $row['Profile_Image'];
                                                echo '<img src="' . $profileImageSrc . '" class="img-fluid" />';
                                            } else {
                                                // Default image if no profile image is provided
                                                echo '<img src="/img/default-profile-image.jpg" class="img-fluid" />';
                                            }
                                            ?>
                                            <ul class="list-unstyled team-social mb-0">
                                                <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-facebook"></i></a></li>
                                                <li class="mt-2"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-linkedin"></i></a></li>
                                                <li class="mt-2"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body content text-center">
                                            <?php echo '<a href="view_doctor.php?doctor_id=' . $row['Doctor_ID'] . '" class="title text-dark h5 d-block mb-0">' . $row['Doctor_Name'] . '</a>'; ?>
                                            <small class="text-muted department-name"><?php echo $row['Dept_Name']; ?></small>
                                        </div>
                                    </div>
                                </div> <!-- Close the column div for each doctor card -->
                                <?php
                            }
                        } else {
                            echo "No doctors found.";
                        }
                        ?>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    </body>
</html>