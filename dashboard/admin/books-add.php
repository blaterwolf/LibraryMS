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
    <!-- JQUERY -->
    <script src="../../assets/node_modules/jquery/dist/jquery.js"></script>
    <!-- SWEETALERT, SANA GUMANA KA NA. -->
    <link rel="stylesheet" href="../../assets/node_modules/sweetalert2/dist/sweetalert2.css" />
    <link rel="stylesheet" href="../../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../assets/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>

<body>
    <div class="overall-dashboard">
        <?php include('includes/header.php') ?>
        <div class="overall-body">
            <?php include('includes/nav.php') ?>
            <div class="output-panel">
                <div class="nav-card">
                    <a class="each-card btn btn-primary text-start active" href="books-add.php">
                        <i class="bi bi-plus-circle"></i>&emsp;
                        Add Book
                    </a>
                    <a class="each-card btn btn-primary text-start" href="books-edit.php">
                        <i class="bi bi-pencil"></i>&emsp;
                        Edit Book
                    </a>
                </div>
                <div class="form">
                    <p class="fs-4">Add Book</p>
                    <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="mb-3 col-sm">
                                <label for="book_isbn" class="form-label">Book ISBN</label>
                                <input required name="isbn" type="text" class="form-control" id="book_isbn"
                                    placeholder="1234567890123" maxlength="13">
                            </div>
                            <div class="mb-3 col-sm">
                                <label for="book_name" class="form-label">Title of Book</label>
                                <input required name="title" type="text" class="form-control" id="book_name"
                                    placeholder="The Legend of Sword" maxlength="100">
                            </div>
                            <div class="mb-3 col-sm">
                                <label for="book_author" class="form-label">Author Name</label>
                                <input required name="author" type="text" class="form-control" id="book_author"
                                    placeholder="Xingqiu" maxlength="100">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="book_description" class="form-label">Description of Book:</label>
                            <textarea required name="description" class="form-control" id="book_description" rows="2"
                                maxlength="500"
                                placeholder="Amid a sea of stars that spin in reverse, light-centuries of war unfold down on the planet's surface... With this grandiose opening comes an all-new tale of gallantry!"></textarea>
                        </div>
                        <div class="row">
                            <?php include('./call_db/call_category.php')  ?>
                            <div class="mb-3 col-sm">
                                <label for="book_author" class="form-label">Number of Copies</label>
                                <input required name="numCopies" type="number" class="form-control" id="book_author"
                                    placeholder="5">
                            </div>
                        </div>
                        <div class="error-space text-center">
                            <?php
                            // * Check if pinindot na ng user yung Add Book Button.
                            if (isset($_POST['add_books'])) {
                                $book_id = generateID();
                                $book_isbn = $_REQUEST['isbn'];
                                $book_name = $_REQUEST['title'];
                                $book_author = $_REQUEST['author'];
                                $book_description = $_REQUEST['description'];
                                $book_category = $_REQUEST['category'];
                                $book_copies_actual = (int)$_REQUEST['numCopies'];
                                $book_copies_current = (int)$_REQUEST['numCopies'];
                                $book_status = $book_copies_current != 0 ? 1 : 0;
                                // * Call DB to find the Category ID.
                                $params = array(&$book_category);
                                $connection = sqlsrv_connect($server, $connectionInfo);
                                $query = "EXEC R_Get_Category_Name @Cat_Name = ?;";
                                $statement = sqlsrv_prepare($connection, $query, $params);
                                $result = sqlsrv_execute($statement);
                                $row = sqlsrv_fetch_array($statement);
                                $book_category = $row['Category_ID'];
                                // * Call DB again to insert the Book data.
                                $params = array(&$book_id, &$book_isbn, &$book_name, &$book_author, &$book_description, &$book_category, &$book_status, &$book_copies_actual, &$book_copies_current);
                                $query = "EXEC C_Add_New_Book @BookID = ?, @ISBN = ?, @Name = ?, @Author = ?, @Description = ?, @CatID = ?, @Status = ?, @CopiesActual = ?, @CopiesCurrent = ?;";
                                $statement = sqlsrv_prepare($connection, $query, $params);
                                $result = sqlsrv_execute($statement);
                                if ($result === TRUE) {
                                    $_SESSION['insert_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully added book!',showConfirmButton: false,timer: 2000});</script>";
                                    echo $_SESSION['insert_message'];
                                    unset($_SESSION['insert_message']);
                                    header("Refresh:0");
                                } else {
                                    echo "<label class='text-danger'>Something went wrong. Please try again.</label>";
                                }
                            }
                            ?>
                        </div>
                        <div class="buttons-for-login">
                            <button type="submit" name="add_books" id="submit-book-data" class="btn btn-secondary">Add
                                Book</button>
                        </div>
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