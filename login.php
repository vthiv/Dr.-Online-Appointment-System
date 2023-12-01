<?php
    session_start();

    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";

    date_default_timezone_set('Asia/Kuala_Lumpur');

    include("connection.php");

    if($_POST){
        $email = $_POST['useremail'];
        $password = $_POST['userpassword'];

        $error = '<label for="promter" class="form-label"></label>';

        $result = $connection -> query("SELECT * FROM webuser WHERE email = '$email'");
        if($result -> num_rows == 1) {
            $utype = $result -> fetch_assoc()['usertype'];
            if ($utype == '3'){
                $checker = $connection -> query("SELECT * FROM patient WHERE Pat_Email = '$email' AND Pat_Password = '$password'");
                if ($checker -> num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = '3';

                    header('location: patient/index_patient.php');
                } else {
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"> Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype == '1'){
                $checker = $connection -> query("SELECT * FROM admin WHERE Admin_Email = '$email' AND Admin_Password = '$password'");
                if ($checker -> num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = '1';

                    header('location: administrative/index_admin.php');
                } else {
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"> Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype == '2') {
                $checker = $connection -> query("SELECT * FROM doctor WHERE Email = '$email' AND Password = '$password'");
                if ($checker -> num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = '2';

                    header('location: doctor/index_doctor.php');
                } else {
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"> Wrong credentials: Invalid email or password</label>';
                }
            }
        } else {
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"> We cant found any acount for this email.</label>';
        }
    } else {
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--Title-->
        <title>Dr. Online Appointment System | Login</title>

        <!--Favicons-->
        <link rel="apple-touch-icon" sizes="180x180" href="img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="shortcut icon" type="image/x-icon" href="img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="manifest" href="js/manifest.json">
        <meta name="msapplication-TileImage" content="img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <meta name="theme-color" content="#ffffff">

        <!---google fonts link---->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100;1,300;1,400;1,500&display=swap" rel="stylesheet">

        <!--Stylesheets-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/index.css">
        
    </head>
    <body>
        <div class="back-to-home rounded d-none d-sm-block">
            <a href="index.php" class="btn btn-icon btn-primary"><i class="bi bi-house-door-fill"></i></a>
        </div>

        <!-- ======= Main Starts ======= -->
        <section class="bg-home d-flex bg-light">
            <div class="row">
                <div class="col-2 col-lg-4">
                    <img src="img/DR._ONLINE_APPOINTMENT_SYSTEM__LOGO.png" height="200" class="logo" alt="Logo" />
                </div>
            </div>
            <div class="container">
                <h2> Login</h2>
                <form action="" method="POST" >
                    <div class="input-bx">
                        <input type="email" name="useremail" required>
                        <span></span>
                        <label for="useremail">Email</label>
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="input-bx">
                        <input type="password" name="userpassword" required>
                        <span></span>
                        <label for="userpassword">Password</label>
                        <i class="bi bi-lock-fill"></i>
                    </div>

                    <div class="cache-bx">
                        <a href="forget_password.php">Forget Password</a>
                    </div>

                    <?php echo $error ?>

                    <button>Login</button>
                    <p>Don't have an account? <a href="signup.php">Register</a></p>
                </form>
            </div>
            <!-- ======= Main Ends ======= -->
        </section>   
    </body>
</html>