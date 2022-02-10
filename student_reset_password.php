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
    <title>Student Reset Password | LibraryMS (PHP Edition)</title>
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
                <p class="fs-4 text-center">Reset Password</p>
                <div class="form">
                    <form role="form" method="post">
                        <div class="form-floating mb-3">
                            <input name="student_id" required maxlength="12" type="student_id" class="form-control"
                                id="floatingInput" placeholder="109461010203">
                            <label for="floatingInput">Student ID</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" required type="password" class="form-control" id="floatingPassword"
                                placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="retype_password" required type="password" class="form-control"
                                id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Retype Password</label>
                        </div>
                        <div class="captcha-container">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Juan Dela Cruz"
                                    name="captcha" maxlength="5" autocomplete="off">
                                <label for="floatingInput">Captcha</label>
                            </div>
                            <br />
                            <img src='functions/captcha.php' alt="captcha" class="captcha-size" />
                        </div>
                        <div class="error-space text-center">
                            <?php
                            if (isset($_POST['student_rp'])) {
                                if (!empty($_POST['captcha'])) {
                                    if (!($_SESSION['captcha'] == $_POST['captcha'])) {
                                        echo "<label class='text-danger'>Invalid captcha.</label>";
                                    } else {
                                        $student_id = $_REQUEST['student_id'];
                                        $password = $_REQUEST['password'];
                                        $retype_password = $_REQUEST['retype_password'];
                                        if ($password == $retype_password) {
                                            $params = array(&$password, &$student_id);
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "UPDATE Student SET Student_Password = ? WHERE Student_ID = ?";
                                            $statement = sqlsrv_prepare($connection, $query, $params);
                                            $result = sqlsrv_execute($statement);
                                            if ($result === TRUE) {
                                                // February 10, 2022 -> medyo gigil na ako di gumagana yung echo JS function na to...
                                                // GUMAGANA NA TO PAKIGAWAN LANG NG PARAAN PAANO I-RUN YUNG JAVASCRIPT SA ALERT.
                                                // include('functions/alert.php');
                                                header('Location: student_login.php');
                                            } else {
                                                echo "<label class='text-danger'>SQL returns false or null. Call DB Admin.</label>";
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
                            <button name="student_rp" class="btn btn-primary" type="submit">Reset Password</button>
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