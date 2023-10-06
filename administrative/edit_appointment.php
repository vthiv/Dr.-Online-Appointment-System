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

if (isset($_POST["edit_app_btn"]) && isset($_POST["editappointment_id"])) {
    $editappointment_id = $_POST["editappointment_id"];

    // Add these debugging statements in your code
    echo "Debug: Schedule ID: " . $editappointment_id . "<br>";
    echo "Debug: POST Data: " . json_encode($_POST) . "<br>";

    $query = "SELECT a.*, CONCAT(p.Pat_Firstname, ' ', p.Pat_Lastname) AS patient_name, d.Doctor_Name, dept.Dept_Name
                FROM appointment a
                INNER JOIN patient p ON a.Pat_ID = p.Pat_ID
                INNER JOIN doctor d ON a.Doctor_ID = d.Doctor_ID
                INNER JOIN department dept ON d.Dept_ID = dept.Dept_ID
                WHERE a.App_ID = '$editappointment_id'";
    
    $result = mysqli_query($connection, $query);

    if ($result) {
        $appointment = mysqli_fetch_assoc($result);
    } else {
        $msg = "Appointment unable to found.";
    }
} else {
    echo "Error: editappointment_id is not set.";
}

if(isset($_POST['save_appointment'])) {

    $appointment_id = $_POST['Apt_ID'];
    $patientID = $_POST['pat_id'];
    $doctorID = $_POST['doc_id'];
    $departmentID = $_POST['dept_id'];
    $adminID = $_SESSION['admin_id'];
    $app_date = $_POST['App_Date'];
    $app_time = $_POST['App_Time'];
    $app_message = $_POST['app_message'];
    $app_status = $_POST['App_Status'];

    // Update the schedule data in the database
    $update_query = mysqli_query($connection, "UPDATE `appointment` SET Apt_ID='$appointment_id', Pat_ID='$patientID', Doctor_ID='$doctorID', Dept_ID='$departmentID', App_Date='$app_date', App_Time='$app_time', App_Message='$app_message', App_Status='$app_status' WHERE App_id='$editappointment_id'");


    if ($update_query) {
        // Redirect back to the schedule_admin.php page after successful update
        $msg = "Appointment updated successfully";
    } else {
        // Handle the case where the update fails
        $msg = "Failed to update appointment details: " . mysqli_error($connection);
        echo $msg; // Add this line for debugging
    }
}

// Retrieve the admin's name
$adminEmail = $_SESSION["user"];
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
        <title>Admin | Edit Appointment</title>
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
        <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">

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
                    <a class="nav-link" href="appointment_admin.php">
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

            <section class="section dashboard">
                <div class="row">
                    <div class="pagetitle">
                        <h1>Appointments</h1>
                    </div>

                    <div class="col-sm-4 col-3">
                        <h6 class="title">Edit Appointment</h6>
                    </div>
                    
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="appointment_admin.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                            <div class="p-3 pt-4">
                                <form action="" method="POST">
                                <input type="hidden" name="editappointment_id" value="<?php echo $editappointment_id; ?>" >
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Appointment ID <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="appointment_id" value="<?php echo $appointment['Apt_ID']; ?>" readonly> 
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admin Name <span class="text-danger">*</span></label>
                                                <input name="admin_id" id="admin_id" type="text" class="form-control" placeholder="Admin Name:" value="<?php echo $adminName; ?>" readonly /> 
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                                                <select class="form-control patient-name select2input" name="pat_id" id="pat_id">
                                                    <option value="">Select Patient</option>
                                                    <?php 
                                                    // Fetch and display a list of patients from the database
                                                        $fetch_query = mysqli_query($connection,"SELECT * FROM appointment WHERE App_ID='$editappointment_id'");
                                                        $row = mysqli_fetch_array($fetch_query);
                                                        $patient_name = explode(",", $row['patient_name']);
                                                        $patient_name = $patient_name[0];

                                                        $fetch_query = mysqli_query($connection, "SELECT Pat_ID, CONCAT(Pat_Firstname, ' ', Pat_Lastname) AS patient_name FROM patient");
                                                        while ($patient = mysqli_fetch_array($fetch_query)) {
                                                            $selected = ($patient['Pat_ID'] == $appointment['Pat_ID']) ? 'selected="selected"' : '';
                                                            echo '<option ' . $selected . ' value="' . $patient['Pat_ID'] . '">' . $patient['patient_name'] . '</option>';
                                                            }
                                                            ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                                <select class="form-control department-name" name="dept_id" id="dept_id">
                                                    <option value="<?php echo $appointment['Dept_ID']; ?>"><?php echo $appointment['Dept_Name']; ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Doctor Name <span class="text-danger">*</span></label>
                                                <select class="form-control doctor-name select2input" name="doc_id" id="doc_id">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $fetch_query = mysqli_query($connection, "SELECT `Doctor_ID`, `Doctor_Name` FROM `doctor`");
                                                    while ($doctor = mysqli_fetch_array($fetch_query)) {
                                                        $selected = ($doctor['Doctor_ID'] == $appointment['Doctor_ID']) ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $doctor['Doctor_ID'] . '">' . $doctor['Doctor_Name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input name="email" id="email" type="email" class="form-control" value="" />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <input name="phone" id="phone" type="tel" class="form-control" value="" />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                                <input name="app_date" id="app_date" type="date" class="flatpicker flatpicker-input form-control" value="<?php  echo $appointment['App_Date'];  ?>" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Appointment Time <span class="text-danger">*</span></label>
                                                <input name="app_time" id="app_time" type="time" class="form-control timepicker" value="<?php  echo $appointment['App_Time'];  ?>" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Message <span class="text-danger">*</span></label>
                                                <textarea name="app_message" id="app_message" rows="4" class="form-control" required><?php  echo isset($appointment['App_Message']) ? $appointment['App_Message']: '' ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                            <label for="status" class="display-block">Appointment Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1" <?php if(isset($appointment['App_Status']) && $appointment['App_Status'] == 1) echo 'selected'; ?>>Active</option>
                                                <option value="0" <?php if(isset($appointment['App_Status']) && $appointment['App_Status'] == 0) echo 'selected'; ?>>Inactive</option>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="d-grid">
                                                <button name="save_appointment" class="btn btn-outline-primary  submit-btn" type="submit" >UPDATE APPOINTMENT</button>
                                                <BR>
                                                <a href="appointment_admin.php" class="btn btn-soft-primary">CANCEL</a>
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

        <!--Modal Start-->
        <!--Add Appointment form Starts-->
        
        <!--Add Appointment form Ends-->
        <!--Modal End-->



        
        <script src="../js/simplebar.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/select2.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            <?php
                if(isset($msg)) {
                    echo 'swal("' . $msg . '").then(function() {
                        window.location.href = "appointment_admin.php";
                    });';
                }
            ?>
        </script>
        
    </body>
</html>