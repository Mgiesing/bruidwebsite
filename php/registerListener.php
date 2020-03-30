<?php
require_once("databaseConnection.php");


if (isset($_POST['registerFormSubmit'])) {
    //Get username/password from form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordVerify = $_POST['passwordVerify'];

    //Check if user exists
    $check = userExists($username);

    //Check amount of items and check if the user excists or not.
    if (isset($check) && count($check) > 1) {
        $_SESSION['error'] = "Deze gebruiker bestaat al.";
    } else {
        createUser($username, $password, $passwordVerify);
    }

}

// Create user Function
function createUser($username, $password, $passwordVerify)
{
    // Username/Password has to be < 1 and password check if the same password got filled it.
    if (strlen($username) < 1) $error = "Ongeldige gebruikersnaam";
    else if (strlen($password) < 1) $error = "Ongeldig wachtwoord";
    else if (strlen($password) < 1) $error = "Ongeldig wachtwoord";
    else if ($password != $passwordVerify) $error = "Wachtwoorden zijn niet het zelfde.";

    //If there was a error, set it in the session so it can be displayed to the user.
    if (isset($error)) $_SESSION['error'] = $error;
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

        $_SESSION['error'] = "Account aangemaakt!";


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