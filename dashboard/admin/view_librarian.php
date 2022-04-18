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
    <title>View Librarian (Admin) | LibraryMS (PHP Edition)</title>
    <!-- CUSTOM STYLE  -->
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/node_modules/bootstrap-icons/font/bootstrap-icons.css" />
    <!-- DATATABLES CSS -->
    <link rel="stylesheet" type="text/css"
        href="../../assets/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" type="text/css"
        href="../../assets/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <script src="../../assets/node_modules/jquery/dist/jquery.js"></script>
    <script>
    $(document).ready(function() {
        $('#book_table').DataTable();
    });
    </script>
</head>

<body>
    <div class="overall-dashboard">
        <?php include('includes/header.php') ?>
        <div class="overall-body">
            <?php include('includes/nav.php') ?>
            <div class="output-panel">
                <h3>View All Librarian</h3>
                <p>This part of the settings can only be seen by the administrator head.</p>
                <div class="outside-card">
                    <div class="output-overflow">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="book_table" class="table table-hover">
                                        <caption>List of Current Librarian</caption>
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Create Date</th>
                                                <th>Modified Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include('./call_db/find_admin.php') ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php') ?>
    </div>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../../assets/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script type="text/javascript" charset="utf8"
        src="../../assets/node_modules/datatables.net/js/jquery.dataTables.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="../../assets/node_modules/datatables.net/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="../../assets/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="../../assets/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js">
    </script>
</body>

</html>