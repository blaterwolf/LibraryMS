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
                            Edit Book Category
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <form role="form" method="POST"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="mb-3 col-sm">
                                        <label for="book_category" class="form-label">Category</label>
                                        <input value="<?= $book_category ?>" name="book_category" autocomplete="off"
                                            class="form-control" list="book_category_options" id="book_category"
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
                                    <div class="mb-3">
                                        <label for="new_category_name" class="form-label">New Book Category
                                            Name:</label>
                                        <input required name="new_category_name" type="text" class="form-control"
                                            id="book_category" autocomplete="off" placeholder="Type Here..."
                                            maxlength="100">
                                    </div>
                                    <div class="error-space text-center">
                                        <?php
                                        if (isset($_POST['edit_book_category'])) {
                                            $book_category_name = $_POST['book_category'];
                                            $new_book_category_name = $_POST['new_category_name'];
                                            // * Check if Book Category exists
                                            $params = array(&$book_category_name);
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "EXEC R_Get_CatID_Based_On_CatName @Cat_Name = ?;";
                                            $statement = sqlsrv_prepare($connection, $query, $params);
                                            $result = sqlsrv_execute($statement);
                                            $row = sqlsrv_fetch_array($statement);
                                            $book_category_id = $row['Category_ID'];
                                            if ($book_category_id == NULL) {
                                                echo "<label class='text-danger'>Category Name you entered in the first input does not exist in the database! Please do not modify.</label>";
                                            } else {
                                                $params = array(&$book_category_id, &$new_book_category_name);
                                                $query = "EXEC U_Update_Category_Name @CatID = ?, @Name = ?;";
                                                $statement = sqlsrv_prepare($connection, $query, $params);
                                                $result = sqlsrv_execute($statement);
                                                if ($result) {
                                                    $_SESSION['BC_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully edited book category!',showConfirmButton: false,timer: 2000});</script>";
                                                    echo "<script type='text/javascript'> document.location = 'books_add.php'; </script>";
                                                } else {
                                                    $_SESSION['BC_message'] = "<script>Swal.fire({icon: 'error',title: 'Unsuccesful edited book category!',text: 'You may have messed up typing something to the form, please try again.',showConfirmButton: false,timer: 2000});</script>";
                                                    echo "<script type='text/javascript'> document.location = 'books_add.php'; </script>";
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="buttons-for-login">
                                        <button type="submit" name="edit_book_category" id="edit_book_category"
                                            class="btn btn-secondary">Edit
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