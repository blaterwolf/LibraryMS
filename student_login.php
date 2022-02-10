<?php
// documentation of the code can be found on admin_login.php
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
    <title>Student Login | LibraryMS (PHP Edition)</title>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" />
    <script>
    </script>
</head>

<body>
    <!-- MAIN -->
    <div class="overall">
        <div class="left-panel">
            <?php include('includes/header_login.php') ?>
            <div class="form">
                <p class="fs-4 text-center">Student Login</p>
                <div class="form">
                    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-floating mb-3">
                            <input name="email" type="email" required maxlength="100" class="form-control"
                                id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" required maxlength="16" class="form-control"
                                id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="captcha-container">
                            <div class="form-floating mb-3">
                                <input type="text" required class="form-control" id="floatingInput"
                                    placeholder="Juan Dela Cruz" name="captcha" maxlength="5" autocomplete="off">
                                <label for="floatingInput">Captcha</label>
                            </div>
                            <br />
                            <img src='functions/captcha.php' alt="captcha" class="captcha-size" />
                        </div>
                        <div class="error-space text-center">
                            <?php
                            if (isset($_POST['student_login'])) {
                                if (!empty($_POST['captcha'])) {
                                    if (!($_SESSION['captcha'] == $_POST['captcha'])) {
                                        echo "<label class='text-danger'>Invalid captcha.</label>";
                                    } else {
                                        $email = $_REQUEST['email'];
                                        $password = ($_REQUEST['password']);
                                        try {
                                            $params = array(&$email, &$password);
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "SELECT Student_ID, Student_Email, Student_Password FROM Student WHERE Student_Email = ? AND Student_Password = ?;";
                                            $statement = sqlsrv_prepare($connection, $query, $params);
                                            $result = sqlsrv_execute($statement);
                                            $row = sqlsrv_fetch_array($statement);
                                            if ($result === TRUE) {
                                                if ($row['Student_Email'] == $email and $row['Student_Password'] == $password) {
                                                    $_SESSION['student_login'] = $row['Student_ID'];
                                                    header("Location: dashboard/student/dashboard.php");
                                                } else {
                                                    echo "<label class='text-danger'>Invalid username or password.</label>";
                                                }
                                            } else {
                                                echo "<label class='text-danger'>SQL returns false or null. Call DB Admin.</label>";
                                            }
                                        } catch (PDOException $e) {
                                            exit("Error: " . $e->getMessage());
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="buttons-for-login">
                            <button name="student_login" class="btn btn-primary" type="submit">Login</button>
                            <a class="btn btn-outline-primary" href="student_sign_up.php">Sign Up</a>
                            <a class="ordinary-redirects" href="student_reset_password.php">Forgot Password?</a>
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
</body>

</html>