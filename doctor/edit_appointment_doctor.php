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

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Doctor | Edit Appointment</title>
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
                        <img src="../img/doctors/<?php echo $profileImage; ?>" class="rounded-circle shadow-md avatar avatar-md-md" />
                        <h5 class="mt-3 mb-1"><?php echo $doctorName; ?></h5>
                        <p class="text-muted mb-0">Doctor in <?php echo $departmentName; ?></p>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="index_doctor.php">
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
                    <a class="nav-link" href="schedule_doctor.php">
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

            <section class="section dashboard">
                <div class="row">
                    <div class="pagetitle">
                        <h1>Appointments</h1>
                    </div>

                    <div class="col-sm-4 col-3">
                        <h6 class="title">Edit Appointment</h6>
                    </div>
                    
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="appointment_doctor.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="p-3 pt-4">
                            <?php
                            $editAppointmentID = "";
                            if (isset($_POST['editappointment_id'])) {
                                $editAppointmentID = $_POST['editappointment_id'];
                            
                                // Perform query to fetch the specific appointment details
                                $query = "SELECT a.*, p.Pat_Email, p.Pat_PhoneNo, CONCAT(p.Pat_Firstname, ' ', p.Pat_Lastname) AS patient_name, 
                                            d.Doctor_Name, dept.Dept_Name
                                            FROM appointment a
                                            INNER JOIN patient p ON a.Pat_ID = p.Pat_ID
                                            INNER JOIN doctor d ON a.Doctor_ID = d.Doctor_ID
                                            INNER JOIN department dept ON d.Dept_ID = dept.Dept_ID
                                            WHERE a.Apt_ID = '$editAppointmentID'";

                                $result = mysqli_query($connection, $query);
                            
                                if ($result && mysqli_num_rows($result) > 0) {
                                    // Display fetched data in an editable form
                                    $appointmentData = mysqli_fetch_assoc($result);
                            
                                    // Display an HTML form pre-populated with the fetched data
                            echo '<form action="" method="POST">
                            <input type="hidden" name="editappointment_id" value="" >
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment ID <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="editappointment_id" value="' . $appointmentData['Apt_ID'] . '" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="patient_name" value="'.$appointmentData['patient_name'].'" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Department <span class="text-danger">*</span></label>
                                            <input name="dept_name" id="dept_name" class="form-control type="text" value="'.$departmentName.'" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Doctor Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="doctor_name" value="'.$appointmentData['Doctor_Name'] . '" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input name="email" id="email" type="email" class="form-control" value="'.$appointmentData['Pat_Email'] . '" readonly />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input name="phone" id="phone" type="tel" class="form-control" value="'.$appointmentData['Pat_PhoneNo'] . '" readonly />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                            <input name="app_date" id="app_date" type="date" class="flatpicker flatpicker-input form-control" value="' . $appointmentData['App_Date'] . '" required />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment Time <span class="text-danger">*</span></label>
                                            <input name="app_time" id="app_time" type="time" class="form-control timepicker" value="' . $appointmentData['App_Time'] . '" required />
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Message <span class="text-danger">*</span></label>
                                            <textarea name="app_message" id="app_message" rows="4" class="form-control" placeholder="Your Message :" required>'.$appointmentData['App_Message'].'</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Prescription <span class="text-danger">*</span></label>
                                            <textarea name="app_prescription" id="app_prescription" rows="4" class="form-control" placeholder="Prescription :" required>'.$appointmentData['Prescription'].'</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label for="app_Status" class="display-block">Appointment Status</label>
                                            <select class="form-control" id="app_Status" name="app_Status">
                                                <option value="1" '.($appointmentData['App_Status'] == 1 ? 'selected' : '').'>Active</option>
                                                <option value="0" '.($appointmentData['App_Status'] == 0 ? 'selected' : '').'>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-grid">
                                            <button name="save_appointment" class="btn btn-outline-primary  submit-btn" type="submit" >UPDATE APPOINTMENT</button>
                                            <br>
                                            <a href="appointment_doctor.php" class="btn btn-soft-primary">CANCEL</a>
                                        </div>
                                    </div>
                                </div>
                            </form>';

                                    
                            // Handle the form submission to update the appointment
                                if (isset($_POST['save_appointment'])) {
                                    // Retrieve the updated data from the form
                                    $updatedDate = $_POST['app_date'];
                                    $updatedTime = $_POST['app_time'];
                                    $updatedPrescription = $_POST['app_prescription'];
                                    $updatedStatus = $_POST['app_Status'];

                                    // Perform query to update the appointment details
                                    $updateQuery = "UPDATE appointment SET App_Date = '$updatedDate', App_Time = '$updatedTime', Prescription = '$updatedPrescription', App_Status = '$updatedStatus'  WHERE Apt_ID = '$editAppointmentID'";
                                    $updateResult = mysqli_query($connection, $updateQuery);

                                    if ($updateResult) {
                                        $msg = "Appointment updated successfully!";
                                    } else {
                                        $msg = "Error updating appointment: " . mysqli_error($connection);
                                    }
                                }
                            } else {
                                $msg = "No appointment found with the provided ID.";
                            }
                        }
                            ?>
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
                        window.location.href = "appointment_doctor.php";
                    });';
                }
            ?>
        </script>
        
    </body>
</html>