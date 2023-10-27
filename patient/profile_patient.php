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
$patientEmail = $_SESSION["user"]; //Assuming store the doctor's email in the session
$query = "SELECT `Pat_ID`, CONCAT(Pat_Firstname, ' ', Pat_Lastname) AS `patient_name`, `Pat_PhoneNo`, `Pat_DOB`, `Pat_Address` FROM `patient` WHERE `Pat_Email` = '$patientEmail'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $patientData = mysqli_fetch_assoc($result);
    $patientID = $patientData['Pat_ID'];
    $patientName = $patientData['patient_name'];
    $patientPhone = $patientData['Pat_PhoneNo'];
    $patientDOB = $patientData['Pat_DOB'];
    $patientAddress = $patientData['Pat_Address'];
    
} else {
    $patientName = "Patient"; // Default name if not found
}

if (isset($_POST['submit_patient_details'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $updateQuery = "UPDATE `patient` SET Pat_Firstname = '$firstName', Pat_Lastname = '$lastName', Pat_PhoneNo = '$phone', Pat_DOB = '$dob', Pat_Address = '$address' WHERE Pat_Email = '$email'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // Update successful, fetch updated data
        $patientName = $firstName . ' ' . $lastName;
        $patientEmail = $email;
        $patientPhone = $phone;
        $patientDOB = $dob;
        $patientAddress = $address;
    } else {
        // Handle update failure
        $message = "Failed to update profile details. Please try again.";
    }
}

if (isset($_POST['submit_new_password'])) {
    $currentPassword = $_POST['currentpassword'];
    $newPassword = $_POST['newpassword'];
    $reenteredPassword = $_POST['renewpassword'];

    // Retrieve the patient's current password
    $query = "SELECT Pat_Password FROM patient WHERE Pat_Email = '$patientEmail'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['Pat_Password'];

        if ($currentPassword === $storedPassword) {
            if ($newPassword === $reenteredPassword) {
                // Update the patient's password
                $updateQuery = "UPDATE `patient` SET Pat_Password = '$newPassword' WHERE Pat_Email = '$patientEmail'";
                $updateResult = mysqli_query($connection, $updateQuery);

                if ($updateResult) {
                    $message = "Password updated successfully.";
                    header("Location: ../index.php");
                } else {
                    $message = "Failed to update the password. Please try again.";
                }
            } else {
                $message = "New password and re-entered password do not match.";
            }
        } else {
            $message = "Current password is incorrect.";
        }
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
        <title>Patient | Profile</title>
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
        
        <link href="../css/header&sidebar.css" rel="stylesheet" />
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
                    <a class="nav-link collapsed" href="doctors_patient.php">
                        <i class="bi bi-heart-pulse"></i>
                        <span>Doctors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile_patient.php">
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
                <h1>Profile</h1>
            </div>

            <section class="section profile">
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile -->
                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                <h2><?php echo $patientName; ?></h2>
                                <h3 class="text-muted mb-0">Patient</h3>
                                <div class="social-links mt-2">
                                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Profile End -->
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body pt-3">
                                <!-- Tabs Starts-->
                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                    </li>
                                </ul>
                                <!-- Tabs Ends-->

                                <!-- Profile Overview Starts-->
                                <div class="tab-content pt-2">
                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                        <h5 class="card-title">Profile Details</h5>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Full Name</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $patientName; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Email</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $patientEmail; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Phone</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $patientPhone; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Date of Birth</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $patientDOB; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Address</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $patientAddress; ?></div>
                                        </div>
                                    </div>
                                    <!-- Profile Overview Ends-->

                                    <!-- Profile Edit Starts-->
                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->
                                        <form method="POST">

                                            <div class="row mb-3">
                                                <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="firstName" type="text" class="form-control" id="firstName" value="<?php echo explode(' ', $patientName)[0]; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="lastName" type="text" class="form-control" id="lastName" value="<?php echo explode(' ', $patientName)[1]; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="email" type="email" class="form-control" id="Email" value="<?php echo $patientEmail; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="DateofBirth" class="col-md-4 col-lg-3 col-form-label">Date of Birth</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="dob" type="text" class="form-control" id="dob" value="<?php echo $patientDOB; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo $patientPhone; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="address" type="text" class="form-control" id="address" value="<?php echo $patientAddress; ?>">
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary" name="submit_patient_details">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Profile Edit Ends-->

                                    <!-- Profile Change Password Starts-->
                                    <div class="tab-pane fade pt-3" id="profile-change-password">
                                        <!-- Change Password Form -->
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="currentpassword" type="password" class="form-control" id="currentPassword">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="newpassword" type="password" class="form-control" id="newPassword">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" name="submit_new_password" class="btn btn-primary">Change Password</button>
                                            </div>
                                        </form><!-- End Change Password Form -->

                                    </div>
                                    <!-- Profile Change Password Ends-->

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

        <script src="../js/simplebar.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/select2.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            <?php
                if(isset($message)){
                    echo 'swal("'.$message.'")';
                } 
            ?>
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    </body>
</html>