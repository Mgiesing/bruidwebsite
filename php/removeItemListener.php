<?php
//Start storing user data
session_start();
require_once("databaseConnection.php");

//If username is not in session (logged out) redirect to mywenslijst.
if (!isset($_SESSION['username'])) {
    header("Location: ../mywenslijst.php");
}

//
if(isset($_GET['itemId'])) {
    //Get username/password from form
    $itemId = $_GET['itemId'];
    $groupid = $_SESSION['groupid'];

    if (!isset($itemId)) die("itemId incorrect");
    else {
        $conn = connectdb();

        // prepare and bind
        $stmt = $conn->prepare("DELETE FROM wenslijst WHERE groupid = ? AND id = ?");
        $stmt->bind_param("ss", $groupid, $itemId);
        $stmt->execute();
    
        if (strlen($stmt->error) > 1) echo "Error description: " . $stmt->error;
        else {
            header("Location: ../mywenslijst.php");
        }

    
        $stmt->close();
        $conn->close();
    }
}
?>