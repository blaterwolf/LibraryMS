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
    <title>Add Category (Admin) | LibraryMS (PHP Edition)</title>
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
                <div class="card-override">
                    <a href="books_add.php" type="text" name="submit_edit_book" class="btn btn-outline-secondary mb-3"
                        form="edit_book_form"><i class="bi bi-arrow-left"></i>&nbsp;&nbsp;<b>Go Back</b></a>
                    <div class="card">
                        <div class="card-header text-center">
                            Add Book Category
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <form role="form" method="POST"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="mb-3">
                                        <label for="book_category" class="form-label">Insert Book Category Name:</label>
                                        <input required name="book_category" type="text" class="form-control"
                                            id="book_category" autocomplete="off" placeholder="Type Here..."
                                            maxlength="100">
                                    </div>
                                    <div class="error-space text-center">
                                        <?php
                                        if (isset($_POST['add_book_category'])) {
                                            $book_category_name = $_POST['book_category'];
                                            $params = array(&$book_category_name);
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "EXEC C_Add_Book_Category @Name = ?;";
                                            $statement = sqlsrv_prepare($connection, $query, $params);
                                            $result = sqlsrv_execute($statement);
                                            if ($result) {
                                                $_SESSION['BC_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully added book category!',showConfirmButton: false,timer: 2000});</script>";
                                                header("Location: books_add.php");
                                            } else {
                                                $_SESSION['BC_message'] = "<script>Swal.fire({icon: 'error',title: 'Unsuccesful added book category!',text: 'You may have messed up typing something to the form, please try again.',showConfirmButton: false,timer: 2000});</script>";
                                                header("Location: books_add.php");
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="buttons-for-login">
                                        <button type="submit" name="add_book_category" id="add_book_category"
                                            class="btn btn-secondary">Add
                                            Book Category</button>
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
</body>

</html>