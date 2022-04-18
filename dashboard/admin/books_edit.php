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
    <title>Edit Books (Admin) | LibraryMS (PHP Edition)</title>
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
                <div class="nav-card">
                    <a class="each-card btn btn-primary text-start" href="books_add.php">
                        <i class="bi bi-plus-circle"></i>&emsp;
                        Add Book
                    </a>
                    <a class="each-card btn btn-primary text-start active" href="books_search.php">
                        <i class="bi bi-pencil"></i>&emsp;
                        Edit Book
                    </a>
                </div>
                <div class="card-override-special">
                    <a href="books_search.php" type="text" name="submit_edit_book"
                        class="btn btn-outline-secondary mb-3" form="edit_book_form"><i
                            class="bi bi-arrow-left"></i>&nbsp;&nbsp;<b>Go Back</b></a>
                    <div class="card">
                        <div class="card-header text-center">
                            Edit Book
                        </div>
                        <div class="card-body">
                            <?php
                            $book_name = $_POST['search_book'];
                            $params = array(&$book_name);
                            $connection = sqlsrv_connect($server, $connectionInfo);
                            $query = "EXEC R_Get_Book_To_Edit @BookName = ?;";
                            $statement = sqlsrv_prepare($connection, $query, $params);
                            $result = sqlsrv_execute($statement);
                            $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
                            if ($row == NULL) {
                                $_SESSION['edit_book_message'] = "<script>Swal.fire({icon: 'error',title: 'Book not found!',text: 'The book you entered did not match anything in the database.',showConfirmButton: false,timer: 3000});</script>";
                                header("Location: books_search.php");
                            } else {
                                $_SESSION['book_id'] = $row['Book_ID'];
                                $book_isbn = $row['Book_ISBN'];
                                $book_name = $row['Book_Name'];
                                $book_author = $row['Book_Author'];
                                $book_description = $row['Book_Description'];
                                $book_category = $row['Category_Name'];
                                $book_copies_actual = $row['Book_Copies_Actual'];
                                $book_copies_current = $row['Book_Copies_Current'];
                                $book_status = $row['Book_Status'];
                            }
                            ?>
                            <form role="form" method="POST" id="edit_book_form"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="row">
                                    <div class="mb-3 col-sm">
                                        <label for="isbn" class="form-label">Book ISBN</label>
                                        <input value="<?= $book_isbn ?>" required name="isbn" type="text"
                                            class="form-control" id="isbn" placeholder="1234567890123" maxlength="13">
                                    </div>
                                    <div class="mb-3 col-sm">
                                        <label for="title" class="form-label">Title of Book</label>
                                        <input value="<?= $book_name ?>" required name="title" type="text"
                                            class="form-control" id="title" placeholder="The Legend of Sword"
                                            maxlength="100">
                                    </div>
                                    <div class="mb-3 col-sm">
                                        <label for="author" class="form-label">Author Name</label>
                                        <input value="<?= $book_author ?>" required name="author" type="text"
                                            class="form-control" id="author" placeholder="Xingqiu" maxlength="100">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description of Book:</label>
                                    <textarea required name="description" class="form-control" id="description" rows="2"
                                        maxlength="500"
                                        placeholder="Amid a sea of stars that spin in reverse, light-centuries of war unfold down on the planet's surface... With this grandiose opening comes an all-new tale of gallantry!"><?= $book_description ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-sm">
                                        <label for="category" class="form-label">Category</label>
                                        <input value="<?= $book_category ?>" name="category" autocomplete="off"
                                            class="form-control" list="book_category_options" id="category"
                                            placeholder="Search Category...">
                                        <datalist id="book_category_options">
                                            <?php
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "EXEC R_Get_Book_Categories";
                                            $statement = sqlsrv_prepare($connection, $query);
                                            $result = sqlsrv_execute($statement);
                                            while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
                                                foreach ($row as $key => $value) {
                                                    if ($key == 'Category') {
                                                        echo "<option value='" . $value . "'>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="mb-3 col-sm">
                                        <label for="total_copies" class="form-label">Total Copies</label>
                                        <input value="<?= $book_copies_actual ?>" required name="total_copies"
                                            type="number" class="form-control" id="total_copies" placeholder="Count">
                                    </div>
                                    <div class="mb-3 col-sm">
                                        <label for="current_copies" class="form-label">Current Copies</label>
                                        <input value="<?= $book_copies_current ?>" required name="current_copies"
                                            type="number" class="form-control" id="current_copies" placeholder="Count">
                                    </div>
                                    <div class="mb-3 col-sm">
                                        <label for="book_status" class="form-label">Status</label>
                                        <input value="<?= $book_status == 0 ? 'Unavailable' : 'Available' ?>"
                                            name="book_status" autocomplete="off" class="form-control"
                                            list="book_status_options" id="book_status" placeholder="Search Status...">
                                        <datalist id="book_status_options">
                                            <option value="Available"></option>
                                            <option value="Unavailable"></option>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="error-space text-center">
                                    <?php
                                    // * Check if pinindot na ng user yung Edit Book Button.
                                    if (isset($_POST['submit_edit_book'])) {
                                        // ! Call $book_id, buhay pa yung variable na yun beh.
                                        $book_id = $_SESSION['book_id'];
                                        $book_isbn = $_REQUEST['isbn'];
                                        $book_name = $_REQUEST['title'];
                                        $book_author = $_REQUEST['author'];
                                        $book_description = $_REQUEST['description'];
                                        $book_category = $_REQUEST['category'];
                                        $book_copies_actual = (int)$_REQUEST['total_copies'];
                                        $book_copies_current = (int)$_REQUEST['current_copies'];
                                        $book_status = $_REQUEST['book_status'] == 'Available' ? 1 : 0;
                                        // * Call DB to find the Category ID.
                                        $params = array(&$book_category);
                                        $connection = sqlsrv_connect($server, $connectionInfo);
                                        $query = "EXEC R_Get_CatID_Based_On_CatName @Cat_Name = ?;";
                                        $statement = sqlsrv_prepare($connection, $query, $params);
                                        $result = sqlsrv_execute($statement);
                                        $row = sqlsrv_fetch_array($statement);
                                        $book_category = $row['Category_ID'];
                                        // * Call DB again to update the Book data.
                                        //var_dump($book_id, $book_isbn, $book_name, $book_author, $book_description, $book_category, $book_copies_actual, $book_copies_current, $book_status);
                                        $connection = sqlsrv_connect($server, $connectionInfo);
                                        $params = array(&$book_id, &$book_isbn, &$book_name, &$book_author, &$book_description, &$book_category, &$book_status, &$book_copies_actual, &$book_copies_current);
                                        $query = "EXEC U_Edit_Book @BookID = ?, @ISBN = ?, @Name = ?, @Author = ?, @Description = ?, @CatID = ?, @Status = ?, @CopiesActual = ?, @CopiesCurrent = ?;";
                                        $statement = sqlsrv_prepare($connection, $query, $params);
                                        $result = sqlsrv_execute($statement);
                                        if ($result) {
                                            $_SESSION['edit_book_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully edited book!',showConfirmButton: false,timer: 2000});</script>";
                                            unset($_SESSION['book_id']);
                                            header("Location: books_search.php");
                                        } else {
                                            $_SESSION['edit_book_message'] = "<script>Swal.fire({icon: 'error',title: 'Unsuccessful editing book!',text: 'You may have messed up typing something to the form, please try again.', showConfirmButton: false,timer: 2000});</script>";
                                            unset($_SESSION['book_id']);
                                            header("Location: books_search.php");
                                        }
                                        die();
                                        exit();
                                    }
                                    ?>
                                </div>
                                <div class="buttons-for-login">
                                    <button type="submit" name="submit_edit_book" id="submit_edit_book"
                                        class="btn btn-secondary" form="edit_book_form">Edit
                                        Book</button>
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