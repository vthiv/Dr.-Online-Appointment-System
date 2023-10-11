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
        <title>Admin | Doctors List</title>
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
                        <h1>Doctors</h1>
                    </div>

                    <div class="col-sm-4 col-3">
                        <h6 class="title">Doctors List</h6>
                    </div>
                    
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add_doctor_admin.php" class="btn btn-primary btn-rounded"><i class="bi bi-plus"></i>Add Doctor</a>
                    </div>
                </div>

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
                                        <a href="view_doctor.php" class="title text-dark h5 d-block mb-0"><?php echo $row['Doctor_Name']; ?></a>
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
        <script src="https://scripts.sirv.com/sirvjs/v3/sirv.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js" ></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/select2.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="../js/theme.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#doctorlist').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </script>
        <script>
            require( 'datatables.net-bs5' );
            require( 'datatables.net-buttons-bs5' );
            require( 'datatables.net-buttons/js/buttons.html5.js' );
            require( 'datatables.net-buttons/js/buttons.print.js' );
            require( 'datatables.net-scroller-bs5' );
            require( 'datatables.net-searchpanes-bs5' );
        </script>
        
    </body>
</html>