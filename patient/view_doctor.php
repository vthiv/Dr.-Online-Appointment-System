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

//Retrieve the patient's name
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

// Retrieve the doctor's information based on the selected doctor ID or email
if (isset($_GET['doctor_id'])) {
    $doctorId = $_GET['doctor_id'];
    $query = "SELECT * FROM `doctor` WHERE `Doctor_ID` = '$doctorId'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $doctorData = mysqli_fetch_assoc($result);
        $doctorID = $doctorData['Doctor_ID'];
        $doctorName = $doctorData['Doctor_Name'];
        $doctorEmail = $doctorData['Email'];
        $deptID = $doctorData['Dept_ID'];
        $doctorBio = $doctorData['Doctor_Bio'];
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
}

// Retrieve doctors with department details using INNER JOIN
$doctorsQuery = "SELECT d.*, dept.Dept_Name FROM doctor d INNER JOIN department dept ON d.Dept_ID = dept.Dept_ID";
$doctorsResult = mysqli_query($connection, $doctorsQuery);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Patient | View Doctor</title>
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
            <section class="section dashboard">
                <div class="row">
                    <div class="pagetitle">
                        <h1>Doctor</h1>
                    </div>

                    <div class="col-sm-4">
                        <h6 class="title">Doctor Profile</h6>
                    </div>

                    <div class="col-sm-8 text-right m-b-20">
                        <a href="doctors_patient.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="layout-specing">
                        <div class="card bg-white rounded shadow overflow-hidden mt-4 border-0">
                            <div class="p-5 bg-primary bg-gradient"></div>
                            <div class="avatar-profile d-flex margin-nagative mt-n5 position-relative ps-3">
                                <img src="../img/doctors/<?php echo $doctorData['Profile_Image']; ?>" class="rounded-circle shadow-md avatar avatar-medium" />
                                <div class="mt-4 ms-3 pt-3">
                                    <h5 class="mt-3 mb-1"><?php echo $doctorData['Doctor_Name']; ?></h5>
                                    <p class="text-muted mb-0"><?php echo $deptData['Dept_Name']; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mt-4">
                                <div class="card border-0 rounded-0 p-4">
                                    <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded shadow overflow-hidden bg-light" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link rounded-0 active" id="overview-tab" data-bs-toggle="pill" href="#pills-overview" role="tab" aria-controls="pills-overview" aria-selected="false">
                                                <div class="text-center pt-1 pb-1">
                                                    <h4 class="title fw-normal mb-0">Overview</h4>
                                                </div>
                                            </a><!--end nav link-->
                                        </li><!--end nav item-->

                                        <li class="nav-item">
                                            <a class="nav-link rounded-0" id="experience-tab" data-bs-toggle="pill" href="#pills-experience" role="tab" aria-controls="pills-experience" aria-selected="false">
                                                <div class="text-center pt-1 pb-1">
                                                    <h4 class="title fw-normal mb-0">My Team</h4>
                                                </div>
                                            </a><!--end nav link-->
                                        </li><!--end nav item-->
                                            
                                        <li class="nav-item">
                                            <a class="nav-link rounded-0" id="timetable-tab" data-bs-toggle="pill" href="#pills-timetable" role="tab" aria-controls="pills-timetable" aria-selected="false">
                                                <div class="text-center pt-1 pb-1">
                                                    <h4 class="title fw-normal mb-0">Time Table</h4>
                                                </div>
                                            </a><!--end nav link-->
                                        </li><!--end nav item-->
                                            
                                        <li class="nav-item">
                                            <a class="nav-link rounded-0" id="settings-tab" data-bs-toggle="pill" href="#pills-settings" role="tab" aria-controls="pills-settings" aria-selected="false">
                                                <div class="text-center pt-1 pb-1">
                                                    <h4 class="title fw-normal mb-0">Settings</h4>
                                                </div>
                                            </a><!--end nav link-->
                                        </li><!--end nav item-->
                                    </ul>

                                    <div class="tab-content mt-2" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="overview-tab">
                                            <p class="text-muted"><?php echo $doctorData['Doctor_Bio']; ?></p>
                                        </div><!--end tab pane-->

                                        <div class="tab-pane fade" id="pills-experience" role="tabpanel" aria-labelledby="experience-tab">
                                            <h5 class="mb-1">Team Members:</h5>

                                            <div class="row row-cols-md-2 row-cols-lg-5">
                                                <div class="col mt-4">
                                                    <?php
                                                    // Retrieve team members from the same department
                                                    $selectedDoctorID = $doctorID;
                                                    $teamQuery = "SELECT * FROM doctor WHERE Dept_ID = {$doctorData['Dept_ID']} AND Doctor_ID != $selectedDoctorID";
                                                    $teamResult = mysqli_query($connection, $teamQuery);

                                                    if($teamResult && mysqli_num_rows($teamResult) > 0){
                                                        while ($teamMember = mysqli_fetch_assoc($teamResult)){
                                                            echo '<div class="card team border-0 rounded shadow overflow-hidden">';
                                                        echo '<div class="team-person position-relative overflow-hidden">';
                                                        echo '<img src="../img/doctors/'. $teamMember['Profile_Image']. '" class="img-fluid" alt="">';
                                                        echo '<ul class="list-unstyled team-like">';
                                                        echo '<li><a href="#" class="btn btn-icon btn-pills btn-soft-danger"><i class="bi bi-heart"></i></a></li>';
                                                        echo '</ul>';
                                                        echo '</div>';
                                                        echo '<div class="card-body">';
                                                        echo '<a href="#" class="title text-dark h5 d-block mb-0">' . $teamMember['Doctor_Name']. '</a>';
                                                        echo '<small class="text-muted speciality">'.$teamMember['Doctor_Bio'].'</small>';
                                                        echo '<ul class="list-unstyled mt-2 mb-0">';
                                                        echo '<li class="d-flex">';
                                                        echo '<i class="bi bi-geo-alt text-primary align-middle"></i>';
                                                        echo '<small class="text-muted ms-2">'.$teamMember['Doctor_Address'].'</small>';
                                                        echo '</li>';
                                                        echo '</ul>';
                                                        echo '<ul class="list-unstyled mt-2 mb-0">';
                                                        echo '<li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-facebook"></i></a></li>';
                                                        echo '<li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-linkedin"></i></a></li>';
                                                        echo '<li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-twitter"></i></a></li>';
                                                        echo '</ul>';
                                                        echo '</div>';
                                                        echo '</div>';
                                                        }
                                                    }
                                                    ?>
                                                    
                                                </div><!--end col-->
                                            </div>
                                        </div><!--end tab pane-->

                                        <div class="tab-pane fade" id="pills-timetable" role="tabpanel" aria-labelledby="timetable-tab">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="card border-0 p-3 rounded shadow">
                                                        <ul class="list-unstyled mb-0">
                                                        <?php
                                                        // Check if the Doctor_ID is provided in the URL
                                                        if (isset($_GET['doctor_id'])) {
                                                            $selectedDoctorID = $_GET['doctor_id'];

                                                            // Retrieve the schedule for the selected doctor
                                                            $scheduleQuery = "SELECT * FROM schedule WHERE Doctor_ID = $selectedDoctorID ORDER BY Schedule_Day";

                                                            $scheduleResult = mysqli_query($connection, $scheduleQuery);

                                                            if ($scheduleResult && mysqli_num_rows($scheduleResult) > 0) {
                                                                while ($schedule = mysqli_fetch_assoc($scheduleResult)) {
                                                                    echo '<li class="d-flex flex-row justify-content-between">';
                                                                    echo '<p class="text-muted mb-0"><i class="bi bi-clock text-primary align-middle h5 mb-0"></i> ' . $schedule['Schedule_Day'] . '</p>';
                                                                    echo '<p class="text-primary mb-0"><span class="text-dark">Time:</span> ' . $schedule['Schedule_StartTime'] . ' - ' . $schedule['Schedule_EndTime'] . '</p>';
                                                                    echo '</li>';
                                                                }
                                                            } else {
                                                                echo '<li class="text-muted mb-0">No schedule available.</li>';
                                                            }
                                                        }
                                                        ?>
                                                        </ul>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-lg-3 col-md-3 mt-3 mt-lg-0 pt-2 pt-lg-0">
                                                    <div class="card border-0 text-center features feature-primary">
                                                        <div class="icon text-center mx-auto rounded-md">
                                                            <i class="bi bi-telephone-fill"></i>
                                                        </div>
                                                        <div class="card-body p-0 mt-2 pb-2">
                                                            <h5 class="title fw-bold">Phone</h5>
                                                            <p class="text-muted">Immediate Assistance</p>
                                                            <a href="tel:+60123456789" class="link">03-612347896</a>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-lg-3 col-md-3 mt-3 mt-lg-0 pt-2 pt-lg-0">
                                                    <div class="card border-0 text-center features feature-primary">
                                                        <div class="icon text-center mx-auto rounded-md">
                                                            <i class="bi bi-envelope-fill"></i>
                                                        </div>
                                
                                                        <div class="card-body p-0 mt-2 pb-2">
                                                            <h5 class="title fw-bold">Email</h5>
                                                            <a href="mailto:contact@example.com" class="link"><?php echo $doctorData['Email']; ?></a>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
                                        </div><!--end tab pane-->

                                        <div class="tab-pane fade" id="pills-settings" role="tabpanel" aria-labelledby="settings-tab">
                                            <h5 class="mb-1">Settings</h5>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="rounded shadow mt-4">
                                                        <div class="p-4 border-bottom">
                                                            <h6 class="mb-0">Personal Information :</h6>
                                                        </div>

                                                        <div class="p-4">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-2 col-md-4">
                                                                    <img src="../img/doctors/<?php echo $doctorData['Profile_Image']; ?>" id="preview" class="avatar avatar-md-md rounded-pill shadow mx-auto d-block" />
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <form class="mt-4" method="POST">
                                                                <input type="hidden" name="doctor_id" value="<?php echo $selectedDoctorID; ?>">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Employee ID</label>
                                                                            <input name="employee_id" id="employee_id" type="text" class="form-control" value="<?php echo $doctorData['Employee_ID']; ?>" readonly>
                                                                        </div>
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Full Name</label>
                                                                            <input name="name" id="name" type="text" class="form-control" value="<?php echo $doctorData['Doctor_Name']; ?>" readonly>
                                                                        </div>
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Your Email</label>
                                                                            <input name="email" id="email" type="email" class="form-control" value="<?php echo $doctorData['Email']; ?>" readonly>
                                                                        </div> 
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Joining Date</label>
                                                                            <input name="joining_date" id="joining_date" type="date" class="form-control" value="<?php echo $doctorData['Doctor_JoiningDate']; ?>" readonly>
                                                                        </div>                                                                               
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Department <span class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text" name="dept_id" id="dept_id" value="<?php echo $departmentName; ?>" readonly>
                                                                        </div>                                                                               
                                                                    </div><!--end col-->

                                                                    <div class="col-md-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Your Bio Here</label>
                                                                            <textarea name="bio" id="bio" rows="4" class="form-control"  readonly><?php echo $doctorData['Doctor_Bio']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div><!--end row-->
                                                            </form><!--end form-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        <script src="../js/jquery.min.js"></script>
        <script src="../js/simplebar.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/select2.min.js"></script>
        <script src="../js/select2.init.js"></script>
        <script src="../js/feather.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

        <script>
            var previousImageSrc = "<?php echo '../img/doctors/' . $doctorData['Profile_Image']; ?>";

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function restoreImage() {
                $('#profile_image').val('');
                $('#preview').attr('src', previousImageSrc);
            }
        </script>

        <script type="text/javascript">
            <?php
                if(isset($message)){
                    echo 'swal("'.$message.'").then(function() {
                        window.location.href = "doctors_admin.php"
                    });';
                } 
            ?>
        </script>
    </body>
</html>