<?php
session_start();
include("connection.php");

$errorEmail = '';
$errorAlert = '';

if(isset($_POST['forgetPassword'])){
    $user_email = $_POST["useremail"];
    $newPassword = $_POST["newPassword"];

    //echo "SELECT * FROM users WHERE email='$user_email'";
    $stmt = $connection->prepare("SELECT * FROM webuser WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result -> num_rows == 0) {
        $errorEmail = "Incorrect Email";
    } else {

        if(strlen($newPassword) < 8) {
            $errorAlert = "Password must be at least 8 characters long.";
        } elseif (!preg_match('/[a-z]/', $newPassword)) {
            $errorAlert = "Password must contain at least one lowercase letter.";
        } elseif (!preg_match('/^[ -~]+$/', $newPassword)) {
            $errorAlert = "Password can only contain alphabetical characters.";
        } elseif (!preg_match('/[!@#$%^&*()_+}{":?><~`\-.,\/\\|]+/', $newPassword)) {
            $errorAlert = "Password must contain at least one symbol (except single quote and semicolon).";
        } else {
            $userrow = $result->fetch_assoc();
            $userType = $userrow["usertype"];

            if ($userType == '1') {
                $updateQuery = "UPDATE admin SET Admin_Password = ? WHERE Admin_Email = ?";
            } elseif ($userType == '2') {
                $updateQuery = "UPDATE doctor SET Password = ? WHERE Email = ?";
            } elseif ($userType == '3') {
                $updateQuery = "UPDATE patient SET Pat_Password = ? WHERE Pat_Email = ?";
            }

            if (isset($updateQuery)) {
                $stmt = $connection->prepare($updateQuery);
                $stmt->bind_param("ss", $newPassword, $user_email);

                if ($stmt->execute()) {
                    echo "Password updated successfully!";
                } else {
                    echo "Error updating password: " . $stmt->error;
                }
            } else {
                echo "Invalid user type";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


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
            <h2> Reset New Password</h2>
            <form action="forget_password.php" method="post">
                <div class="input-bx">
                    <input type="email" name="useremail" required>
                    <span></span>
                    <label for="useremail">Email</label>
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="password" name="newPassword" required>
                    <span></span>
                    <label for="">Password</label>
                    <i class="bi bi-lock-fill"></i>
                </div>

                <button name="forgetPassword">Submit</button>
                <p><a href="login.php">Sign in back</a></p>
            </form>
        </div>
        <!-- ======= Main Ends ======= -->

        <span class="back-icon">
            <a href="index.php" class="btn btn-icon btn-pills btn-soft-primary"><i class="bi bi-house-door-fill"></i></a>
        </span>
    </body>
</html>