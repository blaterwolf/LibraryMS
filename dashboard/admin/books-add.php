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
</head>

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
                    <form role="form" class="form-horizontal" method="post"
                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="name-form" class="form-label">Title of Book</label>
                            <input name="title" type="text" class="form-control" id="name-form"
                                placeholder="The Legend of Sword" maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="book-author" class="form-label">Author Name</label>
                            <input name="author" type="text" class="form-control" id="book-author" placeholder="Xingqiu"
                                maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="book-description" class="form-label">Description of Book:</label>
                            <textarea name="description" class="form-control" id="book-description" rows="3"
                                maxlength="500"
                                placeholder="Amid a sea of stars that spin in reverse, light-centuries of war unfold down on the planet's surface... With this grandiose opening comes an all-new tale of gallantry!"></textarea>
                        </div>
                        <?php include('./call_db/call_category.php')  ?>
                        <div class="mb-3">
                            <label for="book-author" class="form-label">Number of Copies</label>
                            <input name="numCopies" type="number" class="form-control" id="book-author" placeholder="5">
                        </div>
                    </form>
                    <div class="error-space text-center">
                        <?php
                        // * Check if pinindot na ng user yung Add Book Button.
                        if (isset($_POST['add_books'])) {
                            // di pa gumagana...
                            echo var_dump($_POST['add_books']);
                            echo "<label class='text-danger'>Napindot na bhie</label>";
                        }
                        ?>
                    </div>
                    <div class="buttons-for-login">
                        <button name="add_books" id="submit-book-data" class="btn btn-secondary" type="submit">Add
                            Book</button>
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