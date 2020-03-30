<?php
//Start user data storage (so we know who is logged in)
//Put the session to null so it basically kills its self.
//Then go back to index.
session_start();
$_SESSION = null;
session_destroy();

header("Location: ../index.php");

?>