<?php

session_start();

$_SESSION = array();

session_destroy();
$Message = "Wylogowano";
header("Location:index.php?Message=".$Message);

?>