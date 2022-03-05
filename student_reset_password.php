<?php
session_start();
error_reporting(0);
include('includes/config.php');
if ($_SESSION['student_login'] != '') {
    $_SESSION['student_login'] = '';
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
                            <input name="student_number" type="number" required minlength="12" maxlength="12"
                                class="form-control" id="floatingInput" placeholder="123456789012">
                            <label for="floatingInput">Student Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="email" required maxlength="100" type="email" class="form-control"
                                id="floatingInput" placeholder="example@gmail.com">
                            <label for="floatingInput">Email address</label>
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
                                        $student_number = $_REQUEST['student_number'];
                                        $email = $_REQUEST['email'];
                                        $password = $_REQUEST['password'];
                                        $retype_password = $_REQUEST['retype_password'];
                                        // * I check mo muna if yung email na yun ay match sa provided email ni user sa datbaase.
                                        $params = array(&$student_number, &$email);
                                        $connection = sqlsrv_connect($server, $connectionInfo);
                                        $query = "EXEC R_Get_Stud_Email @StudNum = ?, @Email = ?";
                                        $statement = sqlsrv_prepare($connection, $query, $params);
                                        $result = sqlsrv_execute($statement);
                                        $row = sqlsrv_fetch_array($statement);
                                        if ($row['Student_Email'] == $email) {
                                            // * Then check mo if equal password
                                            if ($password == $retype_password) {
                                                $password = password_hash($password, PASSWORD_DEFAULT);
                                                $params = array(&$password, &$student_number);
                                                $connection = sqlsrv_connect($server, $connectionInfo);
                                                $query = "EXEC U_Update_Student_Password @Password = ?, @StudNum = ?;";
                                                $statement = sqlsrv_prepare($connection, $query, $params);
                                                $result = sqlsrv_execute($statement);
                                                if ($result === TRUE) {
                                                    // February 10, 2022 -> medyo gigil na ako di gumagana yung echo JS function na to...
                                                    // GUMAGANA NA TO PAKIGAWAN LANG NG PARAAN PAANO I-RUN YUNG JAVASCRIPT SA ALERT.
                                                    // include('functions/alert.php');
                                                    // March 4, 2022 (17:45) -> reworking this since nabago nga database.
                                                    // March 4, 2022 (~18:30) -> haha hello self gumagana na :D
                                                    $_SESSION['FPW_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully updated your password!',text: 'Redirected you back to Login...',showConfirmButton: false,timer: 2000});</script>";
                                                    header('Location: student_login.php');
                                                } else {
                                                    echo "<label class='text-danger'>SQL returns false or null. Call DB Admin.</label>";
                                                }
                                            } else {
                                                echo "<label class='text-danger'>Password does not match.</label>";
                                            }
                                        } else {
                                            echo "<label class='text-danger'>Invalid email address.</label>";
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