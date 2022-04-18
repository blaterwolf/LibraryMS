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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Librarian (Admin) | LibraryMS (PHP Edition)</title>
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
                <h3>Add Librarian</h3>
                <p>This part of the settings can only be seen by the administrator head.</p>
                <div class="card-override">
                    <div class="card">
                        <div class="card-header text-center">
                            <b>Add New Librarian</b>
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <form role="form" method="POST"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="row">
                                        <div class="mb-3 col-md">
                                            <label for="admin_name" class="form-label">Librarian Name<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input required name="admin_name" type="text" class="form-control"
                                                id="admin_name" placeholder="John Doe" maxlength="100">
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label for="admin_username" class="form-label">Librarian Username<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input required name="admin_username" type="text" class="form-control"
                                                id="admin_username" placeholder="johndoe111" minlength=""
                                                maxlength="20">
                                        </div>
                                    </div>
                                    <span class='badge bg-warning text-dark mb-3'>Password Default: LibraryMS</span>
                                    <br />
                                    <div class="error-space text-center">
                                        <?php
                                        if (isset($_POST['add_librarian'])) {
                                            $admin_name = $_POST['admin_name'];
                                            $admin_username = $_POST['admin_username'];
                                            // * Check for Username Similarity.
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
                                                    allowOutsideClick: false,
                                                    timer: 3000
                                                })
                                                </script>";
                                            } else {
                                                $admin_id = generateID();
                                                $admin_password = password_hash("LibraryMS", PASSWORD_DEFAULT);
                                                $params = array(&$admin_id, &$admin_name, &$admin_username, &$admin_password);
                                                $query = "EXEC C_Add_New_Librarian @AdminID = ?, @Name = ?, @Username = ?, @Password = ?;";
                                                $statement = sqlsrv_prepare($connection, $query, $params);
                                                $result = sqlsrv_execute($statement);
                                                if ($result) {
                                                    echo "<script>
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Librarian Added!',
                                                        text: 'You have successfully added the new librarian: $admin_name.',
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        timer: 3000
                                                    })
                                                    </script>";
                                                } else {
                                                    echo "<script>
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: 'Something went wrong! Unsuccessful in adding the new librarian.',
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        timer: 3000
                                                    })
                                                    </script>";
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <button name="add_librarian" type="submit" class="btn btn-secondary" type="submit">
                                        Add Librarian</button>
                                </form>
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
</body>

</html>