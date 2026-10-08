<?php
// views/logout.php
// Destroys the session so access control can be tested/demonstrated

session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
