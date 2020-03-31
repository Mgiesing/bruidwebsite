<?php
//function to connect to database (easier use)
function connectdb()
{
    $dbUsername = "student";
    $dbPassword = "student";
    $dbHostname = "localhost";
    $dbName = "bruidswebsite";

    // Create connection
    $conn = new mysqli($dbHostname, $dbUsername, $dbPassword, $dbName);


//    // Check connection
//    if ($conn->connect_error) {
//        die("Connection failed: " . $conn->connect_error);
//    }
//    echo "Connected successfully";

    return $conn;
}



function writeGarbage() {

    $conn = connectdb("wenslijst");

    $sql = "INSERT INTO wenslijst (item) VALUES ('wcpapier')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
