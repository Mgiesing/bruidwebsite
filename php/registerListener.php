<?php
require_once("databaseConnection.php");


if (isset($_POST['registerFormSubmit'])) {
    //Get username/password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Check if user exists
    $check = userExists($username);

    if (isset($check) && count($check) > 1) {
        echo "Deze gebruiker bestaat al.";
    } else {
        createUser($username, $password);
    }

}


function createUser($username, $password)
{
    if (!isset($username)) $error = "Invalid Username";
    else if (!isset($password)) $error = "Invalid Password";
    else if (strlen($username) < 1) $error = "Invalid Username";
    else if (strlen($password) < 1) $error = "Invalid Password";

    if (isset($error)) sendError($error);
    else {
        //Hash user password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $groupid = uniqid();
        //Connect to database
        $conn = connectdb();

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, password, groupid) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $groupid);
        $stmt->execute();

        echo "User created";

        $stmt->close();
        $conn->close();
    }

}

function userExists ($username) {
    //Connect to database
    $conn = connectdb();

    //Check if user exists in database
    $sql = "SELECT * FROM users WHERE username=?"; // SQL with parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $user = $result->fetch_assoc(); // fetch data

    return $user;

    $stmt->close();
    $conn->close();
}

?>