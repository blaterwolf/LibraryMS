<?php
session_start();
error_reporting(0);
$current_librarian = $_SESSION['admin_login'];
include('../../includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard (Admin) | LibraryMS (PHP Edition)</title>
    <!-- CUSTOM STYLE  -->
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/node_modules/bootstrap-icons/font/bootstrap-icons.css" />
</head>

<body>
    <div class="overall-dashboard">
        <?php include('includes/header.php') ?>
        <div class="overall-body">
            <?php include('includes/nav.php') ?>
            <div class="output-panel">
                <div class="nav-card">
                    <a class="each-card btn btn-primary text-start" href="books-add.php">
                        <i class="bi bi-plus-circle"></i>&emsp;
                        Add Book
                    </a>
                    <a class="each-card btn btn-primary text-start active" href="books-edit.php">
                        <i class="bi bi-pencil"></i>&emsp;
                        Edit Book
                    </a>
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