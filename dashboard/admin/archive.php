<?php
session_start();
error_reporting(0);
include('../../includes/config.php');
$current_librarian = $_SESSION['admin_login'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Log (Admin) | LibraryMS (PHP Edition)</title>
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

                <h3>Archive Log</h3>
                <p>
                    Books Listing
                </p>
                <div class="output-overflow">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="book_table" class="table table-hover">
                                    <caption>List of Books</caption>
                                    <thead>
                                        <tr>
                                            <th scope="col">ISBN</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Copies Today</th>
                                            <th scope="col">Copies Overall</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('./call_db/get_book_list.php') ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php') ?>
    </div>
    <script src="../../assets/node_modules/jquery/dist/jquery.min.js"></script>
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