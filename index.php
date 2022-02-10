<?php
session_start();
error_reporting(0);
include('includes/config.php');
if ($_SESSION['admin_login'] != '') {
    $_SESSION['admin_login'] = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home | LibraryMS (PHP Edition)</title>
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
                <p class="fs-4 text-center">⬇ Click your Destination</p>
                <div class="buttons-for-login">
                    <a href="student_login.php" class="btn btn-primary" type="button">Student</a>
                    <a href="admin_login.php" class="btn btn-primary" type="button"> Admin</a>
                </div>
            </div>
            <?php include('includes/footer_login.php') ?>
        </div>
        <?php include('includes/right_panel.php') ?>
    </div>
</body>

</html>