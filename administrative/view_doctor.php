<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Title-->
        <title>Admin | View Doctor</title>
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
                        <h1>Doctor</h1>
                    </div>

                    <div class="col-sm-4">
                        <h6 class="title">Doctor Profile</h6>
                    </div>

                    <div class="col-sm-8 text-right m-b-20">
                        <a href="doctors_admin.php" class="btn btn-primary btn-rounded float-right"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="layout-specing">
                        <div class="card bg-white rounded shadow overflow-hidden mt-4 border-0">
                            <div class="p-5 bg-primary bg-gradient"></div>
                            <div class="avatar-profile d-flex margin-nagative mt-n5 position-relative ps-3">
                                <img src="../img/doctors/Calvin Carlo_6525710600513.jpg" class="rounded-circle shadow-md avatar avatar-medium" />
                                <div class="mt-4 ms-3 pt-3">
                                    <h5 class="mt-3 mb-1">Dr. Calvin Carlo</h5>
                                    <p class="text-muted mb-0">Orthopedic</p>
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
                                            <p class="text-muted">qwertyuiop</p>
                                            <h6 class="mb-0">Specialties: </h6>
                                            <ul class="list-unstyled mt-4">
                                                <li class="mt-1"><i class="bi bi-arrow-right-short"></i> Women's health services</li>
                                                <li class="mt-1"><i class="bi bi-arrow-right-short"></i> Pregnancy care</li>
                                                <li class="mt-1"><i class="bi bi-arrow-right-short"></i> Surgical procedures</li>
                                                <li class="mt-1"><i class="bi bi-arrow-right-short"></i> Specialty care</li>
                                                <li class="mt-1"><i class="bi bi-arrow-right-short"></i> Conclusion</li>
                                            </ul>
                                        </div><!--end tab pane-->

                                        <div class="tab-pane fade" id="pills-experience" role="tabpanel" aria-labelledby="experience-tab">
                                            <h5 class="mb-1">Team Members:</h5>

                                            <div class="row row-cols-md-2 row-cols-lg-5">
                                                <div class="col mt-4">
                                                    <div class="card team border-0 rounded shadow overflow-hidden">
                                                        <div class="team-person position-relative overflow-hidden">
                                                            <img src=" " class="img-fluid" alt="">
                                                            <ul class="list-unstyled team-like">
                                                                <li><a href="#" class="btn btn-icon btn-pills btn-soft-danger"><i class="bi bi-heart"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="card-body">
                                                            <a href="#" class="title text-dark h5 d-block mb-0">Louis Batey</a>
                                                            <small class="text-muted speciality">M.B.B.S, Neurologist</small>
                                                            <ul class="list-unstyled mt-2 mb-0">
                                                                <li class="d-flex">
                                                                    <i class="ri-map-pin-line text-primary align-middle"></i>
                                                                    <small class="text-muted ms-2">63, PG Shustoke, UK</small>
                                                                </li>
                                                                <li class="d-flex mt-2">
                                                                    <i class="ri-time-line text-primary align-middle"></i>
                                                                    <small class="text-muted ms-2">Mon: 2:00PM - 6:00PM</small>
                                                                </li>
                                                            </ul>
                                                            <ul class="list-unstyled mt-2 mb-0">
                                                            <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-facebook"></i></a></li>
                                                            <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-linkedin"></i></a></li>
                                                            <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-twitter"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
                                        </div><!--end tab pane-->

                                        <div class="tab-pane fade" id="pills-timetable" role="tabpanel" aria-labelledby="timetable-tab">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="card border-0 p-3 rounded shadow">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-flex justify-content-between">
                                                                <p class="text-muted mb-0"><i class="ri-time-fill text-primary align-middle h5 mb-0"></i> Monday</p>
                                                                <p class="text-primary mb-0"><span class="text-dark">Time:</span> 8.00 - 20.00</p>
                                                            </li>
                                                            <li class="d-flex justify-content-between mt-2">
                                                                <p class="text-muted mb-0"><i class="ri-time-fill text-primary align-middle h5 mb-0"></i> Tuesday</p>
                                                                <p class="text-primary mb-0"><span class="text-dark">Time:</span> 8.00 - 20.00</p>
                                                            </li>
                                                            <li class="d-flex justify-content-between mt-2">
                                                                <p class="text-muted mb-0"><i class="ri-time-fill text-primary align-middle h5 mb-0"></i> Wednesday</p>
                                                                <p class="text-primary mb-0"><span class="text-dark">Time:</span> 8.00 - 20.00</p>
                                                            </li>
                                                            <li class="d-flex justify-content-between mt-2">
                                                                <p class="text-muted mb-0"><i class="ri-time-fill text-primary align-middle h5 mb-0"></i> Thursday</p>
                                                                <p class="text-primary mb-0"><span class="text-dark">Time:</span> 8.00 - 20.00</p>
                                                            </li>
                                                            <li class="d-flex justify-content-between mt-2">
                                                                <p class="text-muted mb-0"><i class="ri-time-fill text-primary align-middle h5 mb-0"></i> Friday</p>
                                                                <p class="text-primary mb-0"><span class="text-dark">Time:</span> 8.00 - 20.00</p>
                                                            </li>
                                                            <li class="d-flex justify-content-between mt-2">
                                                                <p class="text-muted mb-0"><i class="ri-time-fill text-primary align-middle h5 mb-0"></i> Saturday</p>
                                                                <p class="text-primary mb-0"><span class="text-dark">Time:</span> 8.00 - 18.00</p>
                                                            </li>
                                                            <li class="d-flex justify-content-between mt-2">
                                                                <p class="text-muted mb-0"><i class="ri-time-fill text-primary align-middle h5 mb-0"></i> Sunday</p>
                                                                <p class="text-primary mb-0"><span class="text-dark">Time:</span> 8.00 - 14.00</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0 pt-2 pt-lg-0">
                                                    <div class="card border-0 text-center features feature-primary">
                                                        <div class="icon text-center mx-auto rounded-md">
                                                            <i class="bi bi-telephone-fill"></i>
                                                        </div>
                                                        <div class="card-body p-0 mt-4">
                                                            <h5 class="title fw-bold">Phone</h5>
                                                            <p class="text-muted">Immediate Assistance</p>
                                                            <a href="tel:+60123456789" class="link">0123456789</a>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0 pt-2 pt-lg-0">
                                                    <div class="card border-0 text-center features feature-primary">
                                                        <div class="icon text-center mx-auto rounded-md">
                                                            <i class="bi bi-envelope-fill"></i>
                                                        </div>
                                
                                                        <div class="card-body p-0 mt-4">
                                                            <h5 class="title fw-bold">Email</h5>
                                                            <a href="mailto:contact@example.com" class="link">contact@example.com</a>
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
                                                                    <img src=""  class="avatar avatar-md-md rounded-pill shadow mx-auto d-block" />
                                                                </div><!--end col-->

                                                                <div class="col-lg-5 col-md-8 text-center text-md-start mt-4 mt-sm-0">
                                                                    <h6 class="">Upload your picture</h6>
                                                                    <p class="text-muted mb-0">For best results, use an image at least 256px by 256px in either .jpg or .png format</p>
                                                                </div><!--end col-->

                                                                <div class="col-lg-5 col-md-12 text-lg-end text-center mt-4 mt-lg-0">
                                                                    <a href="#" class="btn btn-primary">Upload</a>
                                                                    <a href="#" class="btn btn-soft-primary ms-2">Remove</a>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <form class="mt-4">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Employee ID</label>
                                                                            <input name="employee_id" id="employee_id" type="text" class="form-control" placeholder="Employee ID :">
                                                                        </div>
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Full Name</label>
                                                                            <input name="name" id="name" type="text" class="form-control" placeholder="Full Name :">
                                                                        </div>
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Your Email</label>
                                                                            <input name="email" id="email" type="email" class="form-control" placeholder="Your email :">
                                                                        </div> 
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Date of Birth</label>
                                                                            <input name="dob" id="dob" type="date" class="form-control" placeholder="Date of Birth :">
                                                                        </div>                                                                               
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Phone no.</label>
                                                                            <input name="number" id="number" type="text" class="form-control" placeholder="Phone no. :">
                                                                        </div>                                                                               
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Joining Date</label>
                                                                            <input name="joining_date" id="joining_date" type="date" class="form-control" placeholder="Joining Date :">
                                                                        </div>                                                                               
                                                                    </div><!--end col-->

                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Department</label>
                                                                            <input name="dept_id" id="dept_id" type="text" class="form-control" placeholder="Department :">
                                                                        </div>                                                                               
                                                                    </div><!--end col-->

                                                                    <div class="col-md-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Address</label>
                                                                            <textarea name="address" id="address" rows="4" class="form-control" placeholder="Address :"></textarea>
                                                                        </div>                                                                               
                                                                    </div><!--end col-->

                                                                    <div class="col-md-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Your Bio Here</label>
                                                                            <textarea name="comments" id="comments" rows="4" class="form-control" placeholder="Bio :"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div><!--end row-->
                                                                    
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <input type="submit" id="submit" name="send" class="btn btn-primary" value="Save changes">
                                                                    </div><!--end col-->
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    </body>
</html>