<?php
//Get the group id so we display the correct list
if (isset($_GET['groupId'])) $listgroupId = $_GET['groupId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Happy Brides | Wenslijst</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> </link>
    <script src= https://code.jquery.com/jquery-3.4.1.min.js> </script>
    <script src="/jquery-ui-1.12.1/jquery-ui.js" > </script>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">

    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Inloggen</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="wenslijst.php">Wenslijst</a>
            </li>
        </ul>
    </div>
</nav>
<br> <br>


<!--  script voor de remove button, add button en het slepen van de items -->
<!-- <script>$(document).ready(function () {

        $(".btnAddItem").click(function (e) {
            e.preventDefault();
            $("#Wenslijst").prepend("<li class='list-group-item'><input type='text' placeholder='Gift naam'> <br> <button class='btnDelete btn-danger'>delete</button></li>");

        });
        $("#Wenslijst").on("click", ".btnDelete", function () {
            $(this).parent().remove();
            $("#Wenslijst").sortable();



        });

        $("#Wenslijst").sortable();
    });

</script> -->

<!-- Wenslijst -->
<div class="container">
    <div class="row">
        <div class="jumbotron col-lg-12 col-md-12 col-sm-12">
            <h2>
                Wenslijst
            </h2>
            <br>

            <ul id= "Wenslijst" class="list-group list-group-flush">
                <?php
                require_once("php/databaseConnection.php");

                //Connect to database
                $conn = connectdb();

                //Check if user exists in database
                $sql = "SELECT item FROM wenslijst WHERE groupid = ?"; // SQL with parameters
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $listgroupId);
                $stmt->execute();
                $result = $stmt->get_result(); // get the mysqli result
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<li class="list-group-item">' . htmlspecialchars($row["item"]) . '</li>';
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