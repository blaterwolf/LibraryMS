<?php
/* 
* Bakit kailangan ng session_start(); function?
Stack Overflow: https://stackoverflow.com/questions/871858/php-pass-variable-to-next-page
In order para makapag-pass ka ng session variable sa next page, kailangan ng session_start(); function.
Sabi nga sa SO article:
    ?| Remember to run the session_start(); statement on both these pages before you try to access the 
    ?| $_SESSION array, and also before any output is sent to the browser.
* Bakit kailangan yung session?
February 10, 2022 Assumption: 
    ?| Dahil ito yung gagamitin mong value pang-query sa database para malaman mo kung sino 
    ?| yung user na currently logged in.
    ?| By the time siguro non, iba pa yung logic para sa logout function which is nakita ko
    ?| ko nga sa source code ko. 
* Bakit may if statement sa baba?
    ?| Para siguro hindi na ma-carry over kung sino yung nakalogin na user sa previous page.
*/
session_start();
error_reporting(0);
include('includes/config.php');
if ($_SESSION['admin_login'] != '') {
    $_SESSION['admin_login'] = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Login | LibraryMS (PHP Edition)</title>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" />
    <!-- JQUERY -->
    <script src="../../assets/node_modules/jquery/dist/jquery.js"></script>
</head>

<body>
    <div class="overall">
        <div class="left-panel">
            <?php include('includes/header_login.php') ?>
            <div class="form">
                <p class="fs-4 text-center">Admin Login</p>
                <div class="form">
                    <?php
                    // * comment lang talaga to lol
                    /*
                    * Reference sa action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" na attribute
                    * nilagay ko lang talaga to beh di ko alam kung may effect siya sa mismong code HAAHAHAHA
                    * https://www.w3schools.com/php/php_form_validation.asp
                    */
                    ?>
                    <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-floating mb-3">
                            <input name="username" type="username" required class="form-control" id="floatingInput"
                                placeholder="juandelacruz">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" required class="form-control" id="floatingPassword"
                                placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="captcha-container">
                            <div class="form-floating mb-3">
                                <input type="text" required class="form-control" id="floatingInput"
                                    placeholder="Captcha" name="captcha" maxlength="5" autocomplete="off">
                                <label for="floatingInput">Captcha</label>
                            </div>
                            <br />
                            <img src='functions/captcha.php' alt="captcha" class="captcha-size" />
                        </div>
                        <div class="error-space text-center">
                            <?php
                            // * Check if pinindot na ng user yung Login Button.
                            if (isset($_POST['admin_login'])) {
                                // * Check if hindi empty yung captcha value. Don't worry, yung Bootstrap JS pinipigilan naman
                                // * yung user na mag-submit ng form kapag walang laman yung captcha value.
                                if (!empty($_POST['captcha'])) {
                                    /*
                                    * Check if yung current session captcha is NOT EQUAL sa tinype ng user na captcha.
                                    */
                                    if (!($_SESSION['captcha'] == $_POST['captcha'])) {
                                        echo "<label class='text-danger'>Invalid captcha.</label>";
                                    } else {
                                        /*
                                        From Stack Overflow: https://stackoverflow.com/questions/9002424/php-post-not-working/17375026
                                        Dapat kasi talaga may "name=" attribute ka sa bawat input forms na irerefer mo.
                                        Ayun yung mali na naenounter ko dito since kahapon (February 9, 2022) kasi walang pumapasok na input
                                        from the variables. 
                                        Pero to make sure, ginamit ko na yung _REQUEST method instead of _POST since sabi naman dyan sa 
                                        Stack Overflow article na pwede naman gamitin yun. Though of course, di ko alam kung safe siya for security terms or something.
                                        Oh well, at least nakukuha naman niya yung values sa input ng username and password di kagaya kahapon.
                                        */
                                        $username = $_REQUEST['username'];
                                        $password = $_REQUEST['password'];
                                        try {
                                            $connection = sqlsrv_connect($server, $connectionInfo);
                                            $query = "SELECT AdminUsername, AdminPassword FROM Admin;";
                                            $statement = sqlsrv_prepare($connection, $query);
                                            $result = sqlsrv_execute($statement);
                                            /*
                                            Stack Overflow: (https://stackoverflow.com/questions/19227419/why-is-sqlsrv-fetch-array-returning-null)
                                            The documentation, for sqlsrv_fetch_array, states:
                                            Returns an array on success, NULL if there are no more rows to return, and FALSE if an error occurs.
                                            A NULL result can therefore only mean that there are 0 results from your query.
                                            */
                                            $row = sqlsrv_fetch_array($statement);
                                            // This is always True dahil meron at meron tayong mafefetch na data from the backend.
                                            // In an event na ito ay false dahil maaaring may error na nga sa query, or may error sa connection,
                                            // dapat may else statement.
                                            if ($result === TRUE) {
                                                // salamat Github Copilot :D
                                                if ($row['AdminUsername'] == $username and password_verify($password, $row['AdminPassword'])) {
                                                    $_SESSION['admin_login'] = $username;
                                                    /*
                                                        From the original source code, ang gamit na code is:
                                                            ?| echo "<script type='text/javascript'> document.location ='dashboard/admin/dashboard.php'; </script>";
                                                        Stack Overflow: https://stackoverflow.com/questions/15655017/window-location-js-vs-header-php-for-redirection
                                                        Sabi naman dyan sa article na walang pinagkaiba kung gagamitin ko JS or PHP header function so...
                                                    */
                                                    // * Store javascript code in the session variable so that it can be used in the next page.
                                                    // * Tagapagligtas: https://stackoverflow.com/a/4873865/14043411
                                                    $_SESSION['message'] = "<script>Swal.fire({icon: 'success',title: 'Successfully logged in!',showConfirmButton: false,timer: 1500});</script>";
                                                    header("Location: dashboard/admin/dashboard-home.php");
                                                } else {
                                                    echo "<label class='text-danger'>Invalid username or password.</label>";
                                                }
                                            } else {
                                                echo "<label class='text-danger'>Database returns false or null. Call DB Admin.</label>";
                                            }
                                        } catch (PDOException $e) {
                                            // di ko alam gagawin sa error message na to since kinopya ko nga lang to from the previous code
                                            // but hindi naman umaabot sa point na to so I guess don't fix what's not broken
                                            exit("Error: " . $e->getMessage());
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="buttons-for-login">
                            <button name="admin_login" id="submit-login-data" class="btn btn-primary"
                                type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php include('includes/footer_login.php') ?>
        </div>
        <?php include('includes/right_panel.php') ?>
    </div>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>