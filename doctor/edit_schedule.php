<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$query = "SELECT `Doctor_Name`, `Dept_ID`, `Profile_Image` FROM `doctor` WHERE `Email` = '$doctorEmail'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $doctorData = mysqli_fetch_assoc($result);
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
        <title>Doctor | Edit Schedule</title>
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
                        <h1>Doctor's Schedule</h1>
                    </div>

                    <div class="col-sm-4 col-3">
                        <h6 class="title">Edit Schedule</h6>
                    </div>
                    
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="schedule_doctor.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="card border-0 p-4 rounded shadow">
                            <?php
                            if(isset($_POST['editschedule_id'])){
                                $schedule_id = $_POST['editschedule_id'];

                                $query = "SELECT s.*, d.Doctor_Name, dept.Dept_Name
                                FROM schedule s
                                INNER JOIN doctor d ON s.Doctor_ID = d.Doctor_ID
                                INNER JOIN department dept ON d.Dept_ID = dept.Dept_ID
                                WHERE s.Schedule_ID = $schedule_id";

                                $result = mysqli_query($connection, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $scheduleData = mysqli_fetch_assoc($result);
                                    $doctor_id = $scheduleData['Doctor_Name'];
                                    $dept_id = $scheduleData['Dept_Name'];
                                    $schedule_title = $scheduleData['Schedule_Title'];
                                    $schedule_days = $scheduleData['Schedule_Day'];
                                    $start_time = $scheduleData['Schedule_StartTime'];
                                    $end_time = $scheduleData['Schedule_EndTime'];
                                    $schedule_status = $scheduleData['Schedule_Status'];

                                    // Form for editing the schedule
                                    echo '<form method="POST" action="">
                                        <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Doctor Name <span class="text-danger">*</span></label>
                                                    <input name="doctor_name" id="doctor_name" class="form-control type="text" value="'.$doctor_id.'" readonly/>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Department Name<span class="text-danger">*</span></label>
                                                    <input name="dept_name" id="dept_name" class="form-control type="text" value="'.$dept_id.'" readonly/>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Schedule Days <span class="text-danger">*</span></label><br>
                                                    <select class="select" multiple name="days[]" required>
                                                        <option value="">Select Days</option>
                                                        <option value="Sunday" '.(strpos($schedule_days, 'Sunday') !== false ? 'selected' : '').'>Sunday</option>
                                                        <option value="Monday" '.(strpos($schedule_days, 'Monday') !== false ? 'selected' : '').'>Monday</option>
                                                        <option value="Tuesday" '.(strpos($schedule_days, 'Tuesday') !== false ? 'selected' : '').'>Tuesday</option>
                                                        <option value="Wednesday" '.(strpos($schedule_days, 'Wednesday') !== false ? 'selected' : '').'>Wednesday</option>
                                                        <option value="Thursday" '.(strpos($schedule_days, 'Thursday') !== false ? 'selected' : '').'>Thursday</option>
                                                        <option value="Friday" '.(strpos($schedule_days, 'Friday') !== false ? 'selected' : '').'>Friday</option>
                                                        <option value="Saturday" '.(strpos($schedule_days, 'Saturday') !== false ? 'selected' : '').'>Saturday</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label>Start Time <span class="text-danger">*</span></label>
                                                    <input name="start_time" id="start_time" type="time" class="form-control timepicker" value="'.$start_time.'" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label>End Time <span class="text-danger">*</span></label>
                                                    <input name="end_time" id="end_time" type="time" class="form-control timepicker" value="'.$end_time.'" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Message <span class="text-danger">*</span></label>
                                                    <textarea name="schedule_title" id="schedule_title" cols="30" rows="4" class="form-control">'.$schedule_title.'</textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="display-block">Schedule Status</label>
                                                    <select class="form-control" id="schedule_status" name="schedule_status">
                                                        <option value="1" '.($schedule_status == 1 ? 'selected' : '').'>Active</option>
                                                        <option value="0" '.($schedule_status == 0 ? 'selected' : '').'>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <button type="submit" name="update_schedule" class="btn btn-primary submit-btn">UPDATE SCHEDULE</button>
                                                    <a href="schedule_doctor.php" class="btn btn-soft-primary">CANCEL</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </form>';

                                    if (isset($_POST['update_schedule'])) {
                                        // Retrieve and sanitize form data
                                        $updatedDays = implode(",", $_POST['days']);
                                        $updatedStartTime = $_POST['start_time'];
                                        $updatedEndTime = $_POST['end_time'];
                                        $updatedTitle = $_POST['schedule_title'];
                                        $updatedStatus = $_POST['schedule_status'];
                                    
                                        // Retrieve schedule ID from the form
                                        $schedule_id = $_POST['schedule_id'];
                                    
                                        // Update the schedule in the database
                                        $updateQuery = "UPDATE schedule SET Schedule_Title = '$updatedTitle', Schedule_StartTime = '$updatedStartTime', Schedule_EndTime = '$updatedEndTime', Schedule_Day = '$updatedDays', Schedule_Status = '$updatedStatus' WHERE Schedule_ID = $schedule_id";
                                        $updateResult = mysqli_query($connection, $updateQuery);
                                    
                                        if ($updateResult) {
                                            $message = "Schedule updated successfully!";
                                        } else {
                                            $message = "Error updating schedule";
                                        }
                                    }
                                } else {
                                    $message = "No schedule found with the provided ID.";
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
        <script src="../js/select2.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>                                    
        <script type="text/javascript">
            <?php
                if(isset($message)) {
                    echo 'swal("' . $message . '").then(function() {
                        window.location.href = "schedule_doctor.php";
                    });';
                }
            ?>
        </script>
        
    </body>
</html>