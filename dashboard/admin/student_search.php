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
    <title>Edit Students (Admin) | LibraryMS (PHP Edition)</title>
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
    <?php
    if (isset($_SESSION['edit_student_message'])) {
        echo $_SESSION['edit_student_message'];
        unset($_SESSION['edit_student_message']);
    } ?>
    <div class="overall-dashboard">
        <?php include('includes/header.php') ?>
        <div class="overall-body">
            <?php include('includes/nav.php') ?>
            <div class="output-panel">
                <h3>Manage Students</h3>
                <div class="card-override">
                    <div class="card">
                        <div class="card-header text-center">
                            Search Student
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST" id="search_form" action="student_edit.php">
                                <div class="row g-2 d-flex justify-content-center">
                                    <input required name="search_student" autocomplete="off"
                                        class="form-control col-auto" list="search_student_options" id="search_student"
                                        placeholder="Select Student...">
                                    <datalist id="search_student_options">
                                        <?php
                                        $connection = sqlsrv_connect($server, $connectionInfo);
                                        $query = "EXEC R_Get_Student_Names_For_Search;";
                                        $statement = sqlsrv_prepare($connection, $query);
                                        $result = sqlsrv_execute($statement);
                                        while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
                                            foreach ($row as $key => $value) {
                                                if ($key == 'Student') {
                                                    echo "<option value='$value'>";
                                                }
                                            }
                                        }
                                        ?>
                                    </datalist>
                                    <button type="submit" name="submit_search_book" id="submit_search_book"
                                        class="btn btn-secondary col-auto mx-3" form="search_form">Search
                                        Student</button>
                                </div>
                            </form>
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