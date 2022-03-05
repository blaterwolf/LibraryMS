<?php
session_start();
error_reporting(0);
include('includes/config.php');
if ($_SESSION['login'] != '') {
    $_SESSION['login'] = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Student Sign Up | LibraryMS (PHP Edition)</title>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" />

</head>

<body>
    <div class="overall">
        <div class="left-panel">
            <?php include('includes/header_login.php') ?>
            <div class="form">
                <p class="fs-4 text-center">Sign Up</p>
                <div class="form">
                    <form role="form" method="post">
                        <div class="form-floating mb-3">
                            <input name="student_number" required maxlength="12" type="student_number"
                                class="form-control" id="floatingInput">
                            <label for="floatingInput">Student Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="name" required maxlength="100" type="name" class="form-control"
                                id="floatingInput">
                            <label for="floatingInput">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="email" required maxlength="100" type="email" class="form-control"
                                id="floatingInput">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" required maxlength="16" type="password" class="form-control"
                                id="floatingPassword">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3 ">
                            <input name="retype-password" required maxlength="16" type="password" class="form-control"
                                id="floatingRetypePassword">
                            <label for="floatingRetypePassword">Retype Password</label>
                        </div>
                        <div class="captcha-container">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="captcha" maxlength="5"
                                    autocomplete="off">
                                <label for="floatingInput">Captcha</label>
                            </div>
                            <br />
                            <img src='functions/captcha.php' alt="captcha" class="captcha-size" />
                        </div>
                        <div class="error-space text-center">
                            <?php
                            if (isset($_POST['student_signup'])) {
                                if (!empty($_POST['captcha'])) {
                                    if (!($_SESSION['captcha'] == $_POST['captcha'])) {
                                        echo "<label class='text-danger'>Invalid captcha.</label>";
                                    } else {
                                        $student_id = generateID();
                                        $student_number = $_REQUEST['student_number'];
                                        $name = $_REQUEST['name'];
                                        $email = $_REQUEST['email'];
                                        $password = $_REQUEST['password'];
                                        $retype_password = $_REQUEST['retype-password'];
                                        $status = 1;
                                        if ($password == $retype_password) {
                                            $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
                                            $params = array(&$student_id, &$student_number, &$name, &$email, &$password, &$status);
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "EXEC C_Signup_Student @StudID = ?, @StudNum = ?, @Name = ?, @Email = ?, @Password = ?, @Status = ?;";
                                            $statement = sqlsrv_prepare($connection, $query, $params);
                                            $result = sqlsrv_execute($statement);
                                            if ($result === TRUE) {
                                                // February 10, 2022 -> medyo gigil na ako di gumagana yung echo JS function na to...
                                                // GUMAGANA NA TO PAKIGAWAN LANG NG PARAAN PAANO I-RUN YUNG JAVASCRIPT SA ALERT.
                                                // include('functions/alert.php');
                                                // March 4, 2022 -> nirework ko yung database so nabago 'to, will check and add the notification function na.
                                                // March 4, 2022 (17:44) -> gumagana na 'to haha hello self from the past :D
                                                $_SESSION['sign_up_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully Signed In!',text: 'Redirected you back to Login...',showConfirmButton: false,timer: 2000});</script>";
                                                header('Location: student_login.php');
                                            } else {
                                                echo "<label class='text-danger'>Something went wrong, try again later.</label>";
                                            }
                                        } else {
                                            echo "<label class='text-danger'>Password does not match.</label>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="buttons-for-login">
                            <button name="student_signup" type="submit" class="btn btn-primary" type="submit">
                                Sign Up</button>
                            <a name="login" class="btn btn-outline-primary" href="student_login.php">Return</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php include('includes/footer_login.php') ?>
        </div>
        <?php include('includes/right_panel.php') ?>
    </div>
    <script src="assets/node_modules/jquery/dist/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <!-- yung sweetalert sana gumana kingina beh -->
    <script src="assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</body>

</html>