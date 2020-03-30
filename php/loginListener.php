<?php
require_once("databaseConnection.php");


if(isset($_POST['loginFormSubmit'])) {
    //Get username/password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Check if user exists

    $check = userExists($username);

    if (isset($check) && count($check) > 1) {
        userLogin($username, $password);
    } else {
        echo "User does not exist";
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

function userLogin ($username, $password) {
    $conn = connectdb();

    //Check if user exists in database
    $sql = "SELECT * FROM users WHERE username=?"; // SQL with parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $user = $result->fetch_assoc(); // fetch data

    if (password_verify($password, $user['password'])) {
        echo 'Password is valid!';
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['groupid'] = $user['groupid'];

    } else {
        echo 'Invalid password.';
    }

    $stmt->close();
    $conn->close();

}



?>