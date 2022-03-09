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
    <title>Edit Students (Admin) | LibraryMS (PHP Edition)</title>
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
                <div class="card-override-special">
                    <a href="student_search.php" type="text" name="submit_edit_book"
                        class="btn btn-outline-secondary mb-3" form="edit_book_form"><i
                            class="bi bi-arrow-left"></i>&nbsp;&nbsp;<b>Go Back</b></a>
                    <div class="card">
                        <div class="card-header text-center">
                            Edit Student
                        </div>
                        <div class="card-body">
                            <?php
                            $student_name = explode(' - ', $_POST['search_student'])[0];
                            $params = array(&$student_name);
                            $connection = sqlsrv_connect($server, $connectionInfo);
                            $query = "EXEC R_Get_Student_Info_For_Edit @StudNum = ?;";
                            $statement = sqlsrv_prepare($connection, $query, $params);
                            $result = sqlsrv_execute($statement);
                            $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
                            if ($row == NULL) {
                                $_SESSION['edit_student_message'] = "<script>Swal.fire({icon: 'error',title: 'Student not found!',text: 'The student you entered did not match anything in the database.',showConfirmButton: false,timer: 3000});</script>";
                                header("Location: student_search.php");
                            } else {
                                $_SESSION['student_id'] = $row['Student_ID'];
                                $r_student_number = $row['Student_Number'];
                                $r_student_name = $row['Student_Name'];
                                $r_student_email = $row['Student_Email'];
                                $r_student_status = $row['Student_Status'];
                            }
                            ?>
                            <form role="form" method="POST" id="edit_student_form"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="row">
                                    <div class="mb-3 col-md">
                                        <label for="student_id" class="form-label">Student ID<span
                                                class="text-danger">*</span> <span
                                                class='badge bg-info text-dark'>Database: Unmodifiable</span>
                                        </label>
                                        <input disabled readonly required name="student_id" type="text"
                                            class="form-control" id="student_id" placeholder="Student ID Here..."
                                            onselectstart="return false;" onpaste="return false;" onCopy="return false"
                                            onCut="return false" onDrag="return false" onDrop="return false"
                                            autocomplete=off value="<?= print_r($_SESSION['student_id']); ?>">
                                    </div>
                                    <div class="mb-3 col-md">
                                        <label for="student_number" class="form-label">Student Number<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input required name="student_number" type="number" class="form-control"
                                            id="student_number" placeholder="1234567890123"
                                            value="<?= $r_student_number ?>" maxlength="12">
                                    </div>
                                    <div class="mb-3 col-md">
                                        <label for="student_name" class="form-label">Name<span
                                                class="text-danger">*</span></label>
                                        <input required name="student_name" type="text" class="form-control"
                                            id="student_name" placeholder="Juan Dela Cruz" maxlength="100"
                                            value="<?= $r_student_name ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md">
                                        <label for="student_email" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input required name="student_email" type="email" class="form-control"
                                            id="student_email" placeholder="example@gmail.com" maxlength="255"
                                            value="<?= $r_student_email ?>">
                                    </div>
                                    <div class="mb-3 col-md">
                                        <label for="student_status" class="form-label">Status</label>
                                        <input value="<?= $r_student_status == 0 ? 'Blocked' : 'Active' ?>"
                                            name="student_status" autocomplete="off" class="form-control"
                                            list="book_status_options" id="student_status"
                                            placeholder="Search Status...">
                                        <datalist id="book_status_options">
                                            <option value="Active"></option>
                                            <option value="Blocked"></option>
                                        </datalist>
                                    </div>
                                </div>
                                <span class='badge bg-warning text-dark mb-2'>Password Default: LibraryMS</span>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="checked"
                                        id="reset_password_check" name="reset_password_check">
                                    <label class="form-check-label" for="reset_password_check">
                                        Reset Password for Student
                                    </label>
                                </div>
                                <div class="error-space text-center">
                                    <?php
                                    // * Check if pinindot na ng user yung Edit Student Button.
                                    if (isset($_POST['submit_edit_student'])) {
                                        $student_id = $_SESSION['student_id'];
                                        $student_number = $_POST['student_number'];
                                        $student_name = $_POST['student_name'];
                                        $student_email = $_POST['student_email'];
                                        $student_status = $_POST['student_status'] == 'Active' ? 1 : 0;
                                        $reset_password_check = $_POST['reset_password_check'] == 'checked' ? 1 : 0;
                                        $student_password = password_hash('LibraryMS', PASSWORD_DEFAULT);
                                        // * Call DB to update Student data.
                                        $params = array(
                                            &$student_id, &$student_number, &$student_name, &$student_email,
                                            &$student_status, &$reset_password_check, &$student_password
                                        );
                                        $connection = sqlsrv_connect($server, $connectionInfo);
                                        $query = 'EXEC U_Update_Student_Info @StudID = ?, @StudNum = ?, @Name = ?, @Email = ?, @Status = ?, @ResetPass = ?, @Password = ?;';
                                        $statement = sqlsrv_prepare($connection, $query, $params);
                                        $result = sqlsrv_execute($statement);
                                        if ($result) {
                                            $_SESSION['edit_student_message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully edited student!',showConfirmButton: false,timer: 2000});</script>";
                                            unset($_SESSION['student_id']);
                                            header("Location: student_search.php");
                                        } else {
                                            $_SESSION['edit_student_message'] = "<script>Swal.fire({icon: 'error',title: 'Unsuccessful editing student!',text: 'Something went wrong. Please check if you input the correct details and try again.', showConfirmButton: false,timer: 2000});</script>";
                                            unset($_SESSION['student_id']);
                                            header("Location: student_search.php");
                                        }
                                        die();
                                        exit();
                                    }
                                    ?>
                                </div>
                                <div class="buttons-for-login">
                                    <button type="submit" name="submit_edit_student" id="submit_edit_student"
                                        class="btn btn-secondary" form="edit_student_form">Edit
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
</body>

</html>