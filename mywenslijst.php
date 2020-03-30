<?php
//Start user data storage session
session_start();
//Clear any old errors
if (isset($_SESSION['error'])) unset($_SESSION['error']);

require_once('php/additemListener.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die("401 Unauthorized access.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Happy Brides | Wenslijst</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </link>
    <script src=https://code.jquery.com/jquery-3.4.1.min.js> </script> <script src="/jquery-ui-1.12.1/jquery-ui.js"> </script>
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
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Inloggen</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register.php">Registreer</a></li>';
                }

                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item active"><a class="nav-link" href="mywenslijst.php">MyWenslijst</a></li>';
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

    <!-- Wenslijst -->
    <div class="container">
        <div class="row">
            <div class="jumbotron col-lg-12 col-md-12 col-sm-12">
                <h2>
                    Wenslijst
                </h2>
                <br>

                <div class="alert alert-info" role="alert">
                    Jouw link = <input style="width: 80%;" type="text" readonly value="<?php echo 'http://happybrides.student.local/wenslijst.php?groupId=' . $_SESSION['groupid']; ?>"><br>
                    Of klik <a href="wenslijst.php?groupId=<?php echo $_SESSION['groupid'] ?>">hier</a>
                </div>

                <!-- De List van items -->
                <form method="post">
                    <input type="text" name="itemName" placeholder="wcpapier">
                    <input type="submit" name="submitItem" value="Add Item">
                </form>

                <?php
                //If there is a error, display it to the user.
                if (isset($_SESSION['error'])) {
                    echo '<br><div class="alert alert-primary" role="alert">' . $_SESSION['error'] . '</div>';
                };
                ?>
                <br>

                <ul id="Wenslijst" class="list-group list-group-flush">
                    <?php
                    require_once("php/databaseConnection.php");

                    //Connect to database
                    $conn = connectdb();

                    //Check if user exists in database
                    $sql = "SELECT item, id FROM wenslijst WHERE groupid=?"; // SQL with parameters
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $_SESSION['groupid']);
                    $stmt->execute();
                    $result = $stmt->get_result(); // get the mysqli result
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<li class="list-group-item">' . htmlspecialchars($row["item"]) . '<a href="php/removeItemListener.php?itemId=' . htmlspecialchars($row["id"]) . '" style="float: right;">Delete</a></li>';
                        }
                    } else {
                        echo '<li class="list-group-item">Geen data gevonden.</li>';
                    }
                    $stmt->close();
                    $conn->close();
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>