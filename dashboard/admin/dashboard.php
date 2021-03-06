<?php
session_start();
error_reporting(0);
$current_librarian = $_SESSION['admin_login'];
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
                <?php include('includes/welcome_card.php') ?>
                <div class="nav-card">
                    <a class="each-card btn btn-primary text-start" href="#">
                        <i class="bi bi-list-task"></i>&emsp;
                        Find Book
                    </a>
                    <a class="each-card btn btn-primary text-start" href="#">
                        <i class="bi bi-clipboard-check-fill"></i>&emsp;
                        Find Book Issue
                    </a>
                    <a class="each-card btn btn-primary text-start" href="#">
                        <i class="bi bi-person-fill"></i>&emsp;
                        Find Student
                    </a>
                </div>
                <div class="">

                </div>
            </div>
        </div>
        <?php include('includes/footer.php') ?>
    </div>
    <script src="../../assets/node_modules/jquery/dist/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../../assets/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script>
    var timeDisplay = document.getElementById("time");

    function refreshTime() {
        var dateString = new Date().toLocaleString("en-US", {
            timeZone: "Asia/Manila"
        });
        var formattedString = dateString.replace(", ", " - ");
        timeDisplay.innerHTML = formattedString;
    }

    setInterval(refreshTime, 1000);
    </script>
</body>

</html>