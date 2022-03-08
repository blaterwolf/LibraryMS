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
    <title>Return Books (Admin) | LibraryMS (PHP Edition)</title>
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
                <h3>Return Books</h3>
                <div class="row">
                    <div class="card-override">
                        <div class="card">
                            <div class="card-header text-center">
                                Return Books Form
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="mb-3">
                                        <label for="return_category" class="form-label mb-3">Select below what book
                                            shall be
                                            returned: </label>
                                        <input name="return_category" autocomplete="off" class="form-control mb-3"
                                            list="category-options" id="return_category"
                                            placeholder="Select Return Data">
                                        <datalist id="category-options">
                                            <?php
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "EXEC R_Get_Return_Books;";
                                            $statement = sqlsrv_prepare($connection, $query);
                                            $result = sqlsrv_execute($statement);
                                            while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
                                                foreach ($row as $key => $value) {
                                                    if ($key == 'Return Books') {
                                                        echo "<option value='" . $value . "'>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </datalist>
                                        <div class="error-space text-center">
                                            <?php
                                            if (isset($_POST['submit_return'])) {
                                                $return_data = $_POST['return_category'];
                                                if (count(explode(' - ', $return_data)) != 3) {
                                                    // gets ko na kung bakit lumalabas yung invalid captcha
                                                    // kasi napiprint agad to bago i-unset and nasatisfy naman yung condition
                                                    // kahit null siya.
                                                    // so, gawan ng bagong logic ito para hindi to mangyayari on load.
                                                    echo "<label class='text-danger'>Please select a valid book to return.</label>";
                                                    unset($return_data);
                                                } else {
                                                    $return_data = explode(' - ', $return_data);
                                                    $book_name = $return_data[0];
                                                    $student_name = $return_data[1];
                                                    $copies_got = (int)explode(' ', $return_data[2])[0];
                                                    $params = array(&$book_name, &$student_name, &$copies_got);
                                                    $connection = sqlsrv_connect($server, $connectionInfo);
                                                    $query = "EXEC R_Get_Checked_Return_Books @Book = ?, @Student = ?, @Copies = ?;";
                                                    $statement = sqlsrv_prepare($connection, $query, $params);
                                                    $result = sqlsrv_execute($statement);
                                                    $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
                                                    if ($row != NULL) {
                                                        $borrow_id = $row['Borrow_ID'];
                                                        $book_id = $row['Book_ID'];
                                                        $params = array(&$borrow_id, &$book_id, &$copies_got);
                                                        $connection = sqlsrv_connect($server, $connectionInfo);
                                                        $query = "EXEC U_Return_Books @BorrowID = ?, @BookID = ?, @Copies = ?;";
                                                        $statement = sqlsrv_prepare($connection, $query, $params);
                                                        $result = sqlsrv_execute($statement);
                                                        if ($result) {
                                                            $_SESSION['success_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully returned the book!',showConfirmButton: false,timer: 2000});</script>";
                                                            echo $_SESSION['success_message'];
                                                            unset($_SESSION['success_message']);
                                                        } else {
                                                            echo "<label class='text-danger'>Something went wrong. Failed to return the book.</label>";
                                                        }
                                                    } else {
                                                        echo "<label class='text-danger'>Do not modify returned books input data.</label>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <button type="submit" name="submit_return" id="submit-return-data"
                                            class="btn btn-secondary ">Return Book</button>
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