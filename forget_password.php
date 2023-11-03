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

    $errorAlert = '<label for="promter" class="form-label"></label>';

    if($result -> num_rows == 0) {
        $errorEmail = "Incorrect Email";
    } else {

        if(strlen($newPassword) < 8) {
            $errorAlert = "<label for='promter' class='form-label' style='color:rgb(255, 62, 62);text-align:center;'>Password must be at least 8 characters long.</labe>";
        } elseif (!preg_match('/[a-z]/', $newPassword)) {
            $errorAlert = "<label for='promter' class='form-label' style='color:rgb(255, 62, 62);text-align:center;'>Password must contain at least one lowercase letter.</labe>";
        } elseif (!preg_match('/^[ -~]+$/', $newPassword)) {
            $errorAlert = "<label for='promter' class='form-label' style='color:rgb(255, 62, 62);text-align:center;'>Password can only contain alphabetical characters.</labe>";
        } elseif (!preg_match('/[!@#$%^&*()_+}{":?><~`\-.,\/\\|]+/', $newPassword)) {
            $errorAlert = "<label for='promter' class='form-label' style='color:rgb(255, 62, 62);text-align:center;'>Password must contain at least one symbol (except single quote and semicolon).</labe>";
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
                    $message = "Password updated successfully!";
                } else {
                    $message = "Error updating password: " . $stmt->error;
                }
            } else {
                $message = "Invalid user type";
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

        <!--Title-->
        <title>Dr. Online Appointment System | Forget Password</title>

        <!--Favicons-->
        <link rel="apple-touch-icon" sizes="180x180" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="shortcut icon" type="image/x-icon" href="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <link rel="manifest" href="js/manifest.json">
        <meta name="msapplication-TileImage" content="../img/DR._ONLINE_APPOINTMENT_SYSTEM_White.png">
        <meta name="theme-color" content="#ffffff">

        <!---google fonts link---->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100;1,300;1,400;1,500&display=swap" rel="stylesheet">

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
                    <img src="../img/DR._ONLINE_APPOINTMENT_SYSTEM__LOGO.png" height="200" class="logo" alt="Logo" />
                </div>
            </div>
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

                    <!-- Add this PHP block to display $errorAlert if it's not empty -->
                    <?php if (!empty($errorAlert)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errorAlert; ?>
                        </div>
                    <?php endif; ?>


                    <button name="forgetPassword">Submit</button>
                    <p><a href="login.php">Sign in back</a></p>
                </form>
            </div>
        </section>
        
        <!-- ======= Main Ends ======= -->

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            <?php
                if(isset($message)){
                    echo 'swal("'.$message.'").then(function() {
                        window.location.href = "login.php";
                    });';
                } 
            ?>
        </script>
    </body>
</html>