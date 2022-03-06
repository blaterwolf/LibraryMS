<?php
session_start();
error_reporting(0);
$current_student = $_SESSION['student_login'];
include('../../includes/config.php');
include('call_db/call_stud_name.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings (Student) | LibraryMS (PHP Edition)</title>
    <!-- CUSTOM STYLE  -->
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link href="../../assets/node_modules/bootstrap-show-password-toggle/css/show-password-toggle.css"
        rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/node_modules/bootstrap-icons/font/bootstrap-icons.css" />
    <!-- JQUERY -->
    <script src="../../assets/node_modules/jquery/dist/jquery.js"></script>
    <!-- SWEETALERT, SANA GUMANA KA NA. -->
    <link rel="stylesheet" href="../../assets/node_modules/sweetalert2/dist/sweetalert2.css" />
    <link rel="stylesheet" href="../../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../assets/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
</head>

<body>
    <div class="overall-dashboard">
        <?php include('includes/header.php') ?>
        <div class="overall-body">
            <?php include('includes/nav.php') ?>
            <div class="output-panel">
                <h3>Settings</h3>
                <div class="card-override">
                    <div class="card">
                        <div class="card-header text-center">
                            <b>Personal Information</b>
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <?php
                                include('./call_db/call_settings.php');
                                ?>
                                <form role="form" method="POST"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="row">
                                        <div class="mb-3 col-md">
                                            <label for="student_number" class="form-label">Student Number<span
                                                    class="text-danger">*</span> <span
                                                    class='badge bg-warning text-dark'>Only Editable by Librarian</span>
                                            </label>
                                            <input disabled required name="student_number" type="number"
                                                class="form-control" id="student_number" placeholder="1234567890123"
                                                value="<?= $r_student_number ?>" maxlength="12">
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label for="student_name" class="form-label">Name<span
                                                    class="text-danger">*</span></label>
                                            <input required name="student_name" type="text" class="form-control"
                                                id="student_name" placeholder="Juan Dela Cruz" maxlength="100"
                                                value="<?= $r_student_name ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md">
                                        <label for="student_email" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input required name="student_email" type="email" class="form-control"
                                            id="student_email" placeholder="example@gmail.com" maxlength="255"
                                            value="<?= $r_student_email ?>">
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col">
                                            <label for="new_password" class="form-label">New Password<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input placeholder="Password" minlength="6" maxlength="16"
                                                    autocapitalize="off" autocorrect="off" spellcheck="false"
                                                    name="new_password" type="password" class="form-control rounded"
                                                    required>
                                                <button id="toggle-password" type="button" class="d-none"
                                                    aria-label="Show password as plain text. Warning: this will display your password on the screen.">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="captcha-container-special col-md row">
                                        <div class="mb-3 col-md-2">
                                            <label for="floatingInput">Captcha<span class="text-danger">*</span></label>
                                            <input required type="text" class="col-md form-control" id="floatingInput"
                                                name="captcha" placeholder="12345" maxlength="5" autocomplete="off">
                                        </div>
                                        <br />
                                        <img src='../../functions/captcha.php' alt="captcha"
                                            class="captcha-size-special" />
                                    </div>
                                    <div class="error-space text-center">
                                        <?php
                                        if (isset($_POST['student_signup'])) {
                                            if ($_POST['captcha'] != '') {
                                                if ($_SESSION['captcha'] != $_POST['captcha']) {
                                                    echo "<label class='text-danger'>Invalid captcha.</label>";
                                                } else {
                                                    $n_student_name = $_POST['student_name'];
                                                    $n_student_email = $_POST['student_email'];
                                                    $n_student_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                                                    $params = array(
                                                        &$n_student_name, &$n_student_email,
                                                        &$n_student_password, &$current_student
                                                    );
                                                    $connection = sqlsrv_connect($server, $connectionInfo);
                                                    $query = "EXEC U_Stud_Info_Settings @StudName = ?, @Email = ?, @Password = ?, @StudNum = ?;";
                                                    $statement = sqlsrv_prepare($connection, $query, $params);
                                                    $result = sqlsrv_execute($statement);
                                                    if ($result) {
                                                        $_SESSION['success_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully edited your information!',showConfirmButton: false,timer: 2000});</script>";
                                                        echo $_SESSION['success_message'];
                                                        unset($_SESSION['success_message']);
                                                    } else {
                                                        echo "<label class='text-danger'>Failed to update your information. Please try again later.</label>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <button name="student_signup" type="submit" class="btn btn-secondary" type="submit">
                                        Update Information</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php') ?>
    </div>
    <script src="../../assets/node_modules/jquery/dist/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../../assets/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="../../assets/node_modules/bootstrap-show-password-toggle/js/show-password-toggle.js"></script>
</body>

</html>