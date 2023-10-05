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
            <h2> Register </h2>
            <form>
                <div class="input-bx">
                    <input type="text" required>
                    <span></span>
                    <label for="">Name</label>
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="tel" pattern="[0-9]{3}-[0-9]{7}" minlength="10" maxlength="14" required>
                    <span></span>
                    <label for="">Contact Number (eg: 012-3456789)</label>
                    <i class="bi bi-telephone-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="text" required>
                    <span></span>
                    <label for="">Address</label>
                    <i class="bi bi-house-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="text" required>
                    <span></span>
                    <label for="">Email</label>
                    <i class="bi bi-envelope-fill"></i>
                </div>

                <div class="input-bx">
                    <input type="password" required>
                    <span></span>
                    <label for="">Password</label>
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