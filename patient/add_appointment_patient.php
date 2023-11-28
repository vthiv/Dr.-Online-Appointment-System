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
$query = "SELECT CONCAT(Pat_Firstname, ' ', Pat_Lastname) AS patient_name, Pat_ID, Pat_PhoneNo FROM `patient` WHERE `Pat_Email` = '$patientEmail'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $patientData = mysqli_fetch_assoc($result);
    $patientID = $patientData['Pat_ID'];
    $patientName = $patientData['patient_name'];
    $patientPhone = $patientData['Pat_PhoneNo'];
}
else {
    $patientName = "Patient" ; // Default name if not found
}

$fetch_query = mysqli_query($connection, "SELECT MAX(App_ID) AS App_ID FROM appointment");
$row = mysqli_fetch_row($fetch_query);
if($row[0] == 0) {
    $apt_id = 1;
}
else {
    $apt_id = $row[0] + 1;
}
if(isset($_REQUEST['add_appointment'])) {

    $appointment_id = 'APT-'.$apt_id;
    $doctorID = $_REQUEST['doc_id'];
    $departmentID = $_REQUEST['dept_id'];
    $app_date = $_REQUEST['app_date'];
    $app_time = $_REQUEST['app_time'];
    $app_message = $_REQUEST['app_message'];
    $app_status = $_REQUEST['app_status'];

    $insert_query = mysqli_query($connection, "INSERT INTO `appointment` (Apt_ID, Pat_ID, Doctor_ID, Dept_ID, App_Date, App_Time, App_Message, Prescription, App_Status, App_CreatedAt) VALUES ('$appointment_id', '$patientID', '$doctorID', '$departmentID', '$app_date', '$app_time', '$app_message', '', '$app_status', NOW())");


    if ($insert_query > 0) {
        $msg = "Appointment added successfully!";
    } else {
        $msg = "Error: " . mysqli_error($connection);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Patient | Add Appointment</title>

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
                    <a class="nav-link" href="appointment_patient.php">
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Appointment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed
                    " href="doctors_patient.php">
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
                        <h1>Appointments</h1>
                    </div>

                    <div class="col-sm-4 col-3">
                        <h6 class="title">Add Appointment</h6>
                    </div>
                    
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="appointment_patient.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="p-3 pt-4">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Appointment ID <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="appointment_id" value="<?php if(!empty($apt_id)) { echo 'APT-'.$apt_id; } else { echo "APT-1"; } ?>" disabled> 
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="pat_id" id="pat_id" value="<?php echo $patientName; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Doctor Name <span class="text-danger">*</span></label>
                                            <select class="form-control doctor-name select2input" name="doc_id" id="doc_id" onchange="fetchDepartments(this.value)">
                                                <option value="">Select</option>
                                                <?php
                                                $doctorQuery = "SELECT `Doctor_ID`, `Doctor_Name` FROM `doctor`";
                                                $doctorResult = mysqli_query($connection, $doctorQuery);
                                                    
                                                if ($doctorResult && mysqli_num_rows($doctorResult) > 0) {
                                                    while ($row = mysqli_fetch_assoc($doctorResult)) {
                                                        echo '<option value="' . $row['Doctor_ID'] . '">' . $row['Doctor_Name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Department <span class="text-danger">*</span></label>
                                            <select class="form-control department-name" name="dept_id" id="dept_id">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input name="email" id="email" type="email" class="form-control" value="<?php echo $patientEmail; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input name="phone" id="phone" type="tel" class="form-control" value="<?php echo $patientPhone; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                            <input name="app_date" id="app_date" type="date" class="flatpicker flatpicker-input form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment Time <span class="text-danger">*</span></label>
                                            <input name="app_time" id="app_time" type="time" class="form-control timepicker" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Message <span class="text-danger">*</span></label>
                                            <textarea name="app_message" id="app_message" rows="4" class="form-control" placeholder="Your Message :"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="display-block">Appointment Status <span class="text-danger">*</span></label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="app_status" id="product_active" value="1" checked />
                                                <label class="form-check-label" for="product_active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="app_status" id="product_inactive" value="0">
                                                <label class="form-check-label" for="product_inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-grid">
                                            <button name="add_appointment" class="btn btn-outline-primary">Book an Appointment</button>
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
        <script src="../js/jquery.min.js"></script>
        <script src="../js/select2.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            <?php
                if(isset($msg)) {
                    echo 'swal("' . $msg . '").then(function() {
                        window.location.href = "appointment_patient.php";
                    });';
                }
            ?>
        </script>

        <script>
        function fetchDepartments(doctorId) {
            if (doctorId !== '') {
                $.ajax({
                    type: 'POST',
                    url: 'fetch_departments.php', // You need to create a PHP file named fetch_departments.php to fetch departments based on the selected doctor ID
                    data: { doctorId: doctorId },
                    success: function(response) {
                        $("#dept_id").html(response);
                    }
                });
            } else {
                $("#dept_id").html('<option value="">Select</option>');
            }
        }
        </script>
    </body>
</html>