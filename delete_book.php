<?php

include "db_conn.php"; 

$id = $_GET['id']; 

$query = "DELETE FROM ksiazki where ISBN = '$id'";
$result = $mysqli->query($query);

if ($mysqli->query($query) === TRUE) {
    header("location:admin_books.php");
} 

?>