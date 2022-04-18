<?php
session_start();
error_reporting(0);
$current_librarian = $_SESSION['admin_login']['username'];
if (empty($current_librarian) or !isset($_SESSION["admin_login"])) {
    header("location: ../../403.php");
    exit;
}
include('../../includes/config.php');
include('call_db/call_admin_name.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings (Admin) | LibraryMS (PHP Edition)</title>
    <!-- CUSTOM STYLE  -->
    <link href="../../assets/css/style.css" rel="stylesheet" />
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
                            <b>Librarian Information</b>
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
                                            <label for="admin_name" class="form-label">Librarian Name<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input required name="admin_name" type="text" class="form-control"
                                                id="admin_name" placeholder="John Doe" value="<?= $r_admin_name ?>"
                                                maxlength="100">
                                        </div>
                                        <?php
                                        if ($r_admin_username == 'admin') {
                                        ?>
                                        <div class="mb-3 col-md">
                                            <label for="admin_username" class="form-label">Librarian Username<span
                                                    class="text-danger">*</span> <span
                                                    class='badge bg-info text-dark'>You cannot modify your
                                                    username.</span>
                                            </label>
                                            <input readonly disabled required name="admin_username" type="text"
                                                class="form-control" id="admin_username" placeholder="John Doe"
                                                value="<?= $r_admin_username ?>" maxlength="100">
                                        </div>
                                        <?php
                                        } else {
                                        ?>
                                        <div class="mb-3 col-md">
                                            <label for="admin_username" class="form-label">Librarian Username<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input required name="admin_username" type="text" class="form-control"
                                                id="admin_username" placeholder="John Doe"
                                                value="<?= $r_admin_username ?>" maxlength="100">
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="mb-3 col-md">
                                            <label for="new_password" class="form-label">New Password<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input required name="new_password" type="password" class="form-control"
                                                id="new_password" placeholder="Password" minlength="6" maxlength="16">
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label for="new_retype_password" class="form-label">Retype New Password<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input required name="new_retype_password" type="password"
                                                class="form-control" id="new_retype_password"
                                                placeholder="Retype Password" minlength="6" maxlength="16">
                                        </div>
                                    </div>
                                    <div class="captcha-container-special col-md row">
                                        <div class="col-md-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" required class="form-control" id="floatingInput"
                                                    placeholder="Captcha" name="captcha" minlength="5" maxlength="5"
                                                    autocomplete="off">
                                                <label for="floatingInput">Captcha</label>
                                            </div>
                                        </div>
                                        <br />
                                        <img src='../../functions/captcha.php' alt="captcha"
                                            class="captcha-size-special" />
                                    </div>
                                    <div class="error-space text-center">
                                        <?php
                                        if (isset($_POST['edit_librarian'])) {
                                            // Check password if equal muna and hindi empty.
                                            if ($_POST['new_password'] == $_POST['new_retype_password'] and (!empty($_POST['new_password']) and !empty($_POST['new_retype_password']))) {
                                                if ($_POST['captcha'] != '') {
                                                    if ($_SESSION['captcha'] != $_POST['captcha']) {
                                                        echo "<label class='text-danger'>Invalid captcha.</label>";
                                                    } else {
                                                        $admin_id = $_SESSION['admin_id'];
                                                        $n_admin_name = $_POST['admin_name'];
                                                        $n_admin_username = $_POST['admin_username'];
                                                        $n_admin_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                                                        // * Check Username Validity
                                                        $params = array(&$admin_username);
                                                        $connection = sqlsrv_connect($server, $connectionInfo);
                                                        $query = "EXEC R_Check_Username_Exists @Username = ?;";
                                                        $statement = sqlsrv_prepare($connection, $query, $params);
                                                        $result = sqlsrv_execute($statement);
                                                        $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
                                                        if ($result and !empty($row)) {
                                                            echo "<script>
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Username Already exists!',
                                                                text: 'A fellow librarian has already taken what you have chosen as your username. Please try again.',
                                                                showConfirmButton: false,
                                                                allowOutsideClick: false,
                                                                allowEscapeKey: false,
                                                                footer: '<a href=\'add_librarian.php\'>Try Again</a>'
                                                            })
                                                            </script>";
                                                        } else {
                                                            $params = array(&$n_admin_name, &$n_admin_username, &$n_admin_password, &$admin_id);
                                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                                            $query = "EXEC U_Admin_Info_Settings @Name = ?, @Username = ?, @Password = ?, @AdminID = ?;";
                                                            $statement = sqlsrv_prepare($connection, $query, $params);
                                                            $result = sqlsrv_execute($statement);
                                                            if ($result) {
                                                                echo "<script>
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Librarian Edited!',
                                                                    text: 'You have successfully edited your information.',
                                                                    showConfirmButton: false,
                                                                    allowOutsideClick: false,
                                                                    allowEscapeKey: false,
                                                                    timer: 1500
                                                                })
                                                                </script>";
                                                                header('Refresh: 0');
                                                            } else {
                                                                echo "<script>
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Oops...',
                                                                    text: 'Something went wrong! Unsuccessful in editing your information.',
                                                                    showConfirmButton: false,
                                                                    allowOutsideClick: false,
                                                                    allowEscapeKey: false,
                                                                    footer: '<a href=\'javascript:window.location.reload(true)\'>Try Again</a>'
                                                                })
                                                                </script>";
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo "<label class='text-danger'>Passwords incorrect.</label>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="buttons-for-login">
                                        <button name="edit_librarian" class="btn btn-secondary" type="submit">Edit
                                            Librarian Information</button>
                                    </div>
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
</body>

</html>