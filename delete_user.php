<?php

include "db_conn.php";

$id = $_GET['id'];

$query = "DELETE FROM klienci where klient_id = '$id'";
$result = $mysqli->query($query);

if ($mysqli->query($query) === TRUE) {
    header("location:users.php");
} 

?>