<?php

session_start();
require("../connection.php");

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != '1') {
        header("location: ../index.php");
    }
} else {
    header('Location:../index.php');  // Redirecting To Home Page
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

$fetch_query = mysqli_query($connection, "SELECT MAX(Doctor_ID) AS Doctor_ID FROM doctor");
$row = mysqli_fetch_row($fetch_query);
if($row[0] == 0) {
    $employee_id = 1;
}
else {
    $employee_id = $row[0] + 1;
}
if (isset($_POST['add-doctor'])) {
    // Retrieve other form data
    $emp_id = 'DR-N'.$employee_id;
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $dob = $_POST['dob'];
    $phone = $_POST['phonenumber'];
    $joining_date = $_POST['joining_date'];
    $department_id = $_POST['dept_id'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $bio = $_POST['comments'];
    $status = $_POST['status'];

    // Handle file upload
    if($_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $temp_name = $_FILES['profile_image']['tmp_name'];
        $file_name = $_FILES['profile_image']['name'];
        $file_destination = "../img/doctors/" . $file_name;

        if (move_uploaded_file($temp_name, $file_destination)) {
            $insert_query = mysqli_query($connection, "INSERT INTO doctor SET Employee_ID='$emp_id',Dept_ID='$department_id',Doctor_Name='$fullname',Email='$email',Password='$password',Doctor_DOB='$dob',Doctor_PhoneNo='$phone',Doctor_Address='$address',Doctor_JoiningDate='$joining_date',Doctor_Gender='$gender',Doctor_Bio='$bio', Profile_Image='$file_name',Doctor_Status='$status'");

            if($insert_query >0){
        
                $insert_webuser_query = mysqli_query($connection, "INSERT INTO webuser (email, usertype) VALUES ('$email', '2')");
        
                if($insert_webuser_query) {
                    $message = "Doctor created successfully";
                } else {
                    $message = "Error adding doctor";
                } 
            }
            else {
                $message = "Error adding doctor";
            }
        } else {
            $message = "Error uploading profile image";
        }
    } else {
        $message = "No profile image uploaded or error occurred";
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
        <title>Admin | Add Doctor</title>
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
                        <img src="../img/admin.png" class="rounded-circle shadow-md avatar avatar-md-md" />
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
                    <a class="nav-link" href="doctors_admin.php">
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
                        <h1>Doctor</h1>
                    </div>

                    <div class="col-sm-4">
                        <h6 class="title">Add New Doctor</h6>
                    </div>

                    <div class="col-sm-8 text-right m-b-20">
                        <a href="doctors_admin.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 mt-4">
                        <div class="card border-0 p-4 rounded shadow">
                            <form class="mt-4" method="POST" action="" enctype="multipart/form-data">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 col-md-4">
                                        <img src=" " id="preview" class="avatar avatar-md-md rounded-pill shadow mx-auto d-block" />
                                    </div>

                                    <div class="col-lg-5 col-md-8 text-center text-md-start mt-4 mt-sm-0">
                                        <h5 class="">Upload your picture</h5>
                                        <p class="text-muted mb-0">For best results, use an image at least 600px by 600px in either .jpg or .png format</p>
                                    </div>

                                    <div class="col-lg-5 col-md-12 text-lg-end text-center mt-4 mt-lg-0">
                                        <input type="file" name="profile_image" id="profile_image" accept=".jpg, .png" style="display: none;" onchange="previewImage(this);" />
                                        <label for="profile_image" class="btn btn-primary" style="margin-left: 10px;">Upload</label>
                                        <a href="#" class="btn btn-soft-primary ms-2" onclick="clearImagePreview(); return false;">Remove</a>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Employee ID </label>
                                            <input class="form-control" type="text" name="employee_id" value="<?php if(!empty($employee_id)) { echo 'DR-N'.$employee_id; } else { echo "DR-N1"; } ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input name="fullname" id="fullname" type="text" class="form-control" placeholder="Full Name :" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email</label>
                                            <input name="email" id="email" type="email" class="form-control" placeholder="Email :" required/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control" type="password" name="pwd" id="pwd" placeholder="Password" required/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input name="dob" id="dob" type="date" class="form-control flatpicker flatpicker-input" placeholder="Date of Birth" required/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input name="phonenumber" id="phonenumber" type="text" class="form-control" placeholder="Phone Number :" required/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Joining Date</label>
                                            <div class="cal-icon">
                                            <input name="joining_date" id="joining_date" type="date" class="form-control flatpicker flatpicker-input" placeholder="Joining Date :" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Department</label>
                                            <select class="form-control" name="dept_id" id="dept_id">
                                                <option value="">Select</option>
                                                <?php
                                                $departmentQuery = "SELECT `Dept_ID`, `Dept_Name` FROM `department` WHERE `Dept_Status` = 1";
                                                $departmentResult = mysqli_query($connection, $departmentQuery);
                                                    
                                                if ($departmentResult && mysqli_num_rows($departmentResult) > 0) {
                                                    while ($row = mysqli_fetch_assoc($departmentResult)) {
                                                        echo '<option value="' . $row['Dept_ID'] . '">' . $row['Dept_Name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Gender</label>
                                            <select class="form-control" name="gender">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Address: " required />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Bio Here</label>
                                            <textarea name="comments" id="comments" rows="3" class="form-control" placeholder="Bio :" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Doctor Status</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="doctor_active" value="1" checked />
                                                <label class="form-check-label" for="doctor_active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="doctor_inactive" value="0">
                                                <label class="form-check-label" for="doctor_inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="add-doctor" class="btn btn-primary submit-btn">Add Doctor</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4">
                        <div class="card rounded border-0 shadow">
                            <div class="p-4 border-bottom">
                                <h5 class="mb-0">Doctors List</h5>
                            </div>

                            <ul class="list-unstyled mb-0 p-4" data-simplebar style="height: 664px;">
                            <?php
                            $doctorsQuery = "SELECT * FROM doctor d JOIN department dep ON d.Dept_ID = dep.Dept_ID";
                            $doctorsResult = mysqli_query($connection, $doctorsQuery);

                            // Check if there are any rows returned
                            if ($doctorsResult && mysqli_num_rows($doctorsResult) > 0) {
                                // Display each doctor's details in the provided <div>
                                while ($row = mysqli_fetch_assoc($doctorsResult)) {
                                echo '<li class="d-md-flex align-items-center text-center text-md-start">';
                                    echo '<img src="../img/doctors/' . $row["Profile_Image"] . '" class="avatar avatar-medium rounded-md shadow" />';

                                    echo '<div class="ms-md-3 mt-4 mt-sm-0">';
                                        echo '<a href="#" class="text-dark h6">' . $row["Doctor_Name"] . '</a>';
                                        echo '<p class="text-muted my-1">' . $row["Dept_Name"] . '</p>';
                                        echo '<p class="text-muted mb-0">' . $row["Doctor_Bio"] . '</p>';
                                    echo '</div>';
                                echo '</li>';
                                }
                            } else {
                                echo "No doctors found.";
                            }
                            ?>
                                <li class="mt-4">
                                    <a href="doctors_admin.php" class="btn btn-primary">View More</a>
                                </li>
                            </ul>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function clearImagePreview() {
                $('#profile_image').val('');
                $('#preview').attr('src', '');
            }
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            <?php
                if(isset($message)) {
                    echo 'swal("' . $message . '").then(function() {
                        window.location.href = "doctors_admin.php";
                    });';
                }
            ?>
        </script>
        
    </body>
</html>