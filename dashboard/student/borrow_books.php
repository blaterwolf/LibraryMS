<?php
session_start();
error_reporting(0);
$current_student = $_SESSION['student_login']['student_number'];
if (empty($current_student) or !isset($_SESSION["student_login"])) {
    header("location: ../../403.php");
    exit;
}
include('../../includes/config.php');
include('call_db/call_stud_name.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Books (Student) | LibraryMS (PHP Edition)</title>
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
                <h2>Borrow Books</h2>
                <div class="form">
                    <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <?php include('./call_db/call_book_names.php'); ?>
                        <div class="mb-3 col-sm">
                            <label for="book_copies" class="form-label">How many copies?</label>
                            <input required name="book_copies" type="number" class="form-control" id="book_copies"
                                placeholder="5">
                        </div>
                        <div class="error-space text-center">
                            <?php
                            if (isset($_POST['borrow_button'])) {
                                // * Value from form here:
                                $input_book_name = $_POST['book_name'];
                                $input_num_copies = $_POST['book_copies'];
                                if ($input_num_copies <= 0) {
                                    echo '<script>
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Number of copies cannot be negative!",
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    })
                                    </script>';
                                } else {
                                    // * Call stored procedure for checking the current copy of books here:
                                    $params = array(&$input_book_name);
                                    $connection = sqlsrv_connect($server, $connectionInfo);
                                    $query = "EXEC R_Get_Book_Info @Name = ?;";
                                    $statement = sqlsrv_prepare($connection, $query, $params);
                                    $result = sqlsrv_execute($statement);
                                    $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
                                    if ($row == NULL) {
                                        echo "<label class='text-danger'>The book you provided is not found in the database. Please try again.</label>";
                                    } else {
                                        $book_id = $row['Book_ID'];
                                        $book_copies_current = $row['Book_Copies_Current'];
                                        // * If the provided input of the user is greater than the current number of copies in the database...
                                        if (!($book_copies_current >= $input_num_copies)) {
                                            echo "<label class='text-danger'>Invalid Number: you are borrowing more than the current number of that book. Please indicate the right number of copies to borrow and try again. </label>";
                                        } else {
                                            // * Get student id on the Session Variable 'student_login'
                                            // * Remove R_Stud_Id_By_Stud_Num
                                            $student_id = $_SESSION['student_login']['student_id'];
                                            $borrow_id = generateID();
                                            // * Call stored procedure for inserting and updating the database.
                                            $params = array(&$borrow_id, &$book_id, &$student_id, &$input_num_copies);
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "EXEC C_Add_Borrow_Book @BorrowID = ?, @BookID = ?, @StudentID = ?, @NumCopies = ?;";
                                            $statement = sqlsrv_prepare($connection, $query, $params);
                                            $result = sqlsrv_execute($statement);
                                            if ($result) {
                                                $_SESSION['success_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully borrowed a book!',showConfirmButton: false,timer: 2000});</script>";
                                                echo $_SESSION['success_message'];
                                                unset($_SESSION['success_message']);
                                            } else {
                                                echo "<label class='text-danger'>Failed to borrow the book. Call librarian for details.</label>";
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <button type="submit" name="borrow_button" id="submit-book-data"
                            class="btn btn-secondary col-md-2">Borrow Book</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php') ?>
    </div>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../../assets/node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>