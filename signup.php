<?php
session_start();
require("connection.php");

$_SESSION["user"]="";
$_SESSION["usertype"]="";

if($_POST){

    $result = $connection ->query("SELECT * FROM webuser");

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone=$_POST['phonenumber'];
    $dob=$_POST['dob'];
    $address=$_POST['address'];
    $email= $_POST['email'];
    $newpassword=$_POST['newpassword'];
    $cpassword=$_POST['cpassword'];

    if ($newpassword == $cpassword) {
        $result = $connection ->query("SELECT * FROM webuser WHERE email='$email'");
        if($result ->num_rows == 1) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        } else {
            $connection ->query("INSERT INTO patient (Pat_Firstname, Pat_Lastname, Pat_Email, Pat_Password, Pat_PhoneNo, Pat_DOB, Pat_Address) VALUES ('$firstname', '$lastname', '$email', '$newpassword', '$phone', '$dob', '$address')");
            $connection ->query("INSERT INTO webuser (email, usertype) VALUES ('$email', '3')");

            $_SESSION["user"]=$email;
            $_SESSION["usertype"]="3";

            header('Location: patient/index_patient.php');
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
        }
    } else {
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm the Password</label>';
    }

} else {
    $error='<label for="promter" class="form-label"></label>';
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--Title-->
        <title>Sign Up</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!---google fonts link---->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100;1,300;1,400;1,500&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>

        <div class="col-2 col-lg-4">
            <img src="img/DR._ONLINE_APPOINTMENT_SYSTEM__LOGO.png" alt="logo">
        </div>

        <!-- ======= Main Starts ======= -->
        <div class="container">
            <h2> Register </h2>
            <form method="POST" action="">
                <div class="input-bx">
                    <input type="text" name="firstname" required>
                    <span></span>
                    <label for="">First Name</label>
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="text" name="lastname" required>
                    <span></span>
                    <label for="">Last Name</label>
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="tel" name="phonenumber" pattern="[0-9]{3}-[0-9]{7}" minlength="10" maxlength="14" required>
                    <span></span>
                    <label for="">Contact Number (eg: 012-3456789)</label>
                    <i class="bi bi-telephone-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="date" name="dob" required>
                    <span></span>
                    <label for="">Date of Birth</label>
                    <i class="bi bi-calendar-heart-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="text" name="address" required>
                    <span></span>
                    <label for="">Address</label>
                    <i class="bi bi-house-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="text" name="email" required>
                    <span></span>
                    <label for="">Email</label>
                    <i class="bi bi-envelope-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="password" name="newpassword" required>
                    <span></span>
                    <label for="">Password</label>
                    <i class="bi bi-lock-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="password" name="cpassword" required>
                    <span></span>
                    <label for="">Confirm Password</label>
                    <i class="bi bi-lock-fill"></i>
                </div>

                <button>Register</button>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
        <!-- ======= Main Ends ======= -->

        <span class="back-icon">
            <a href="index.php" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-house-door-fill"></i></a>
        </span>
    </body>
</html>