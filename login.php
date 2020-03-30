<?php
//Start user data storage session
session_start();
//Clear any old errors
if (isset($_SESSION['error'])) unset($_SESSION['error']);

//Require login listener
require_once('php/loginListener.php');
//Can't go to login page when logged in.
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Happy Brides | Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </link>
    <script src=https://code.jquery.com/jquery-3.4.1.min.js> </script> <script src="/jquery-ui-1.12.1/jquery-ui.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <!-- Dynamic buttons -->
                <?php
                if (!isset($_SESSION['username'])) {
                    echo '<li class="nav-item active"><a class="nav-link" href="login.php">Inloggen</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register.php">Registreer</a></li>';
                }

                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="mywenslijst.php">MyWenslijst</a></li>';
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a style="color: white;" class="nav-link" href="php/logoutListener.php">Logout</a>';
            }
            ?>

        </div>
    </nav>
    <br> <br>
    <!-- Inlog scherm -->

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">

            </div>
            <div class="jumbotron col-lg-4 col-md-4 col-sm-4 text-center">
                <form method="post" id="loginform">
                    <input type="text" name="username" placeholder="Inlognaam">
                    <input type="password" name="password" placeholder="Wachtwoord"> <br><br>
                    <input type="submit" value="Login" name="loginFormSubmit">
                </form>
                <div id="formFooter">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>
                <?php
                //If there is a error, display it to the user.
                if (isset($_SESSION['error'])) {
                    echo '<br><div class="alert alert-primary" role="alert">' . $_SESSION['error'] . '</div>';
                };
                ?>
            </div>
        </div>
</body>

</html>