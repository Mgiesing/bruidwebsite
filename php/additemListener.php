<?php
require_once("databaseConnection.php");


if(isset($_POST['submitItem'])) {
    //Get username/password from form
    $itemName = $_POST['itemName'];
    $groupid = $_SESSION['groupid'];

    $conn = connectdb();

    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO wenslijst (item, groupid) VALUES (?, ?)");
    $stmt->bind_param("ss", $itemName, $groupid);
    $stmt->execute();

    $_SESSION['error'] = "Item toegevoegd!";

    $stmt->close();
    $conn->close();
}
?>