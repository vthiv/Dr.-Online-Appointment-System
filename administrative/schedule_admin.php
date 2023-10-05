<?php
session_start();
require("../connection.php");

if(isset($_SESSION["user"]) && $_SESSION['usertype'] == '1'){
    // Session exists and user is of type 1 (admin)
    $adminEmail = $_SESSION["user"];
    $query = "SELECT `Admin_Name` FROM `admin` WHERE `Admin_Email` = '$adminEmail'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $adminData = mysqli_fetch_assoc($result);
        $adminName = $adminData['Admin_Name'];
    } else {
        $adminName = "Admin"; // Default name if not found
    }
} else {
    // Redirect if the user is not logged in as an admin
    header('Location:../index.php');
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Admin | Doctors Schedule</title>
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
                    <a class="nav-link" href="schedule_admin.php">
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
                        <h1>Schedule</h1>
                    </div>

                    <div class="col-sm-4 col-3">
                        <h6 class="title">Doctor's Schedule</h6>
                    </div>
                    
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add_schedule.php" class="btn btn-primary btn-rounded"><i class="bi bi-plus"></i>Add Doctor Schedule</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-stripped" id="schedulelist" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Department</th>    
                                <th>Schedule Days</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query to fetch schedule data
                            $query = "SELECT s.*, d.Doctor_Name, dept.Dept_Name
                            FROM schedule s
                            INNER JOIN doctor d ON s.Doctor_ID = d.Doctor_ID
                            INNER JOIN department dept ON d.Dept_ID = dept.Dept_ID";

                            $result = mysqli_query($connection, $query);

                            // Check if the query was successful
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                // Extract schedule data
                                $doctorName = $row['Doctor_Name'];
                                $deptName = $row['Dept_Name'];
                                $availableDays = explode(",", $row['Schedule_Day']); // Convert available days to an array
                                $startTime = $row["Schedule_StartTime"];
                                $endTime = $row["Schedule_EndTime"];
                                $status = $row['Schedule_Status']; // Assuming you have a 'Schedule_Status' column

                                // Create HTML table row for each schedule entry
                                echo '<tr>';
                                echo '<td>' . $doctorName . '</td>';
                                echo '<td>' . $deptName . '</td>';
                                echo '<td>' . implode(", ", $availableDays) . '</td>'; // Convert array back to a comma-separated string
                                echo '<td>' . $startTime . '</td>';
                                echo '<td>' . $endTime . '</td>';
                                echo '<td>' . ($status == 1 ? 'Active' : 'Inactive') . '</td>'; // Assuming 1 is for Active and 0 for Inactive
                                echo '<td>
                                        <form action = "edit_schedule.php" method = "POST">
                                            <input type="hidden" name="editschedule_id" value="'. $row['Schedule_ID'].'" >
                                            <button type="submit" name="edit_schedule_btn" class="btn btn-info"><i class="bi bi-pencil-square"></i></button>
                                        </form>
                                      </td>'; // Replace 'Actions' with buttons or links for editing/deleting if needed
                                echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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
        <script src="../js/select2.init.js"></script>
        <script src="../js/tagsinput.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#schedulelist').DataTable();
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