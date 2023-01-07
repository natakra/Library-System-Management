<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nkrauze_library";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
  die("Connection Failed " . $mysqli->connect_error);
}

?>