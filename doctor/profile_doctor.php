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
$query = "SELECT `Doctor_ID`, `Doctor_Name`, `Dept_ID`, `Doctor_PhoneNo`, `Doctor_DOB`, `Doctor_Address`, `Doctor_JoiningDate`, `Doctor_Bio`, `Profile_Image` FROM `doctor` WHERE `Email` = '$doctorEmail'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $doctorData = mysqli_fetch_assoc($result);
    $doctorID = $doctorData['Doctor_ID'];
    $doctorName = $doctorData['Doctor_Name'];
    $deptID = $doctorData['Dept_ID'];
    $doctorphone = $doctorData['Doctor_PhoneNo'];
    $doctordateofbirth = $doctorData['Doctor_DOB'];
    $doctoraddress = $doctorData['Doctor_Address'];
    $doctorjoiningdate = $doctorData['Doctor_JoiningDate'];
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


// Handling form submission for saving doctor details
if (isset($_POST['submit_doctor_details'])) {
    $doctorName = $_POST['fullName'];
    $doctorBio = $_POST['about'];
    $departmentName = $_POST['position'];
    $doctorEmail = $_POST['email'];
    $doctorphone = $_POST['phone'];
    $doctordateofbirth = $_POST['dob'];
    $doctoraddress = $_POST['address'];
    $doctorjoiningdate = $_POST['joindate'];

    // Query to update the doctor's details in the database
    $updateQuery = "UPDATE `doctor` SET `Doctor_Name`='$doctorName', `Doctor_PhoneNo`='$doctorphone', `Doctor_DOB`='$doctordateofbirth', `Doctor_Address`='$doctoraddress', `Doctor_JoiningDate`='$doctorjoiningdate', `Doctor_Bio`='$doctorBio' WHERE `Email`='$doctorEmail'";
    
    // Run the update query
    if (mysqli_query($connection, $updateQuery)) {
        // Data updated successfully
        // You can redirect to the profile page again or show a success message
        $message = "Profile data added successfully!";
    } else {
        // Error in updating the data
        $message = "Error: " . mysqli_error($connection);
    }
}

// Handling form submission for changing the password
if (isset($_POST['submit_new_password'])) {
    $doctorEmail = $_POST['doctorEmail'];
    $currentPassword = $_POST['currentpassword'];
    $newPassword = $_POST['newpassword'];
    $reEnteredPassword = $_POST['renewpassword'];

    // Check if the new password and re-entered password match
    if($newPassword !== $reEnteredPassword) {
        echo '<script>alert("The new password and re-entered password do not match.")</script>';
    } else {
        // Check if the current password is correct
        $passwordCheckQuery = "SELECT `Password` FROM `doctor` WHERE `Email` = '$doctorEmail'";
        $passwordCheckResult = mysqli_query($connection, $passwordCheckQuery);

        if ($passwordCheckResult && mysqli_num_rows($passwordCheckResult) > 0) {
            $data = mysqli_fetch_assoc($passwordCheckResult);
            $currentDBPassword = $data['Password'];

            if ($currentDBPassword === $currentPassword) {
                // Update the password in the database
                $updatePasswordQuery = "UPDATE `doctor` SET `Password`='$newPassword' WHERE `Email`='$doctorEmail'";
                if (mysqli_query($connection, $updatePasswordQuery)) {
                    $message = "Password changed successfully!";
                } else {
                    $message = "Error: " . mysqli_error($connection);
                }
            } else {
                echo '<script>alert("Current password is incorrect.")</script>';
            }
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
        <title>Doctor | Profile</title>
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
                    <a class="nav-link" href="profile_doctor.php">
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
                                <img src="../img/doctors/<?php echo $profileImage; ?>" alt="Profile" class="rounded-circle" />
                                <h2><?php echo $doctorName; ?></h2>
                                <h3 class="text-muted mb-0">Doctor in <?php echo $departmentName; ?></h3>
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
                                        <h5 class="card-title">About</h5>
                                        <p class="small fst-italic"><?php echo $doctorBio; ?></p>

                                        <h5 class="card-title">Profile Details</h5>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Full Name</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $doctorName; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Department</div>
                                            <div class="col-lg-9 col-md-8">Doctor in <?php echo $departmentName; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Email</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $doctorEmail; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Phone</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $doctorphone; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Date of Birth</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $doctordateofbirth; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Join Date</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $doctorjoiningdate; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Address</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $doctoraddress; ?></div>
                                        </div>
                                    </div>
                                    <!-- Profile Overview Ends-->

                                    <!-- Profile Edit Starts-->
                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->
                                        <form method="POST">
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <img src="../img/doctors/<?php echo $profileImage; ?>" alt="Profile" id="preview"  />
                                                    <div class="pt-2">
                                                        <input type="file" name="profile_image" id="profile_image" accept=".jpg, .png" style="display: none;" onchange="previewImage(this);" />
                                                        <a href="#" class="btn btn-primary btn-sm" name="profile_image" id="profile_image" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                        <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image" onclick="restoreImage(); return false;"><i class="bi bi-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $doctorName; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <textarea name="about" class="form-control" id="about" style="height: 100px"><?php echo $doctorBio; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Department" class="col-md-4 col-lg-3 col-form-label">Department</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="position" type="text" class="form-control" id="Department" value="<?php echo $departmentName; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="email" type="email" class="form-control" id="Email" value="<?php echo $doctorEmail; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="DateofBirth" class="col-md-4 col-lg-3 col-form-label">Date of Birth</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="dob" type="date" class="form-control" id="dob" value="<?php echo $doctordateofbirth; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo $doctorphone; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="address" type="text" class="form-control" id="address" value="<?php echo $doctoraddress; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="JoinBirth" class="col-md-4 col-lg-3 col-form-label">Join Date</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="joindate" type="date" class="form-control" id="joindate" value="<?php echo $doctorjoiningdate; ?>">
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary" name="submit_doctor_details">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Profile Edit Ends-->

                                    <!-- Profile Change Password Starts-->
                                    <div class="tab-pane fade pt-3" id="profile-change-password">
                                        <!-- Change Password Form -->
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <!-- Include the adminEmail input field -->
                                            <input type="hidden" name="doctorEmail" value="<?php echo $doctorEmail; ?>">
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
    </body>
</html>