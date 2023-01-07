<?php

include "db_conn.php";
error_reporting(0);

$id = $_GET['id'];

$query = "select * from klienci where klient_id = '$id'";
$result = $mysqli->query($query);
$row=mysqli_fetch_array($result);

$Message = $_GET['Message'];

if(isset($_POST['update']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $adres = $_POST['adres'];
    $kara = $_POST['kara'];

    if(empty($username) || empty($password) || empty($name) || empty($adres) || empty($kara)) {
        $Message = urlencode("Wszystkie pola musza byc wypelnione");
        header("Location: edit_user.php?id=<?php echo $id; ?>?Message=".$Message);
    }
    else {

        $query = "UPDATE klienci set k_username='$username', k_password='$password', k_name='$name', k_adres='$adres', kara='$kara' where klient_id = '$id'";
        $result = $mysqli->query($query);
        
        if ($mysqli->query($query) === TRUE) {
            header("location:users.php");
        } 

        else {
            echo "Błąd: " . $mysqli->error;
        }
        
    }	
}
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Edycja użytkownika</title>
  </head>
  <body>
    
    <div class="card mx-auto border border-primary" style="width: 50%; text-align: center; margin-top: 10%;">
        <div class="card-body">
            <h5 class="card-title">Edycja użytkownika</h5>
            <form action="edit_user.php?id=<?php echo $id; ?>" method="post">
                <label for="username">Nazwa użytkownika</label><br>
                <input type="text" name="username" value='<?php echo $row['k_username'] ?>'><br>
                <label for="password">Hasło</label><br>
                <input type="password" name="password" value='<?php echo $row['k_password'] ?>'><br>
                <label for="name">Imię i nazwisko</label><br>
                <input type="text" name="name" value='<?php echo $row['k_name'] ?>'><br>
                <label for="adres">Adres</label><br>
                <input type="text" name="adres" value='<?php echo $row['k_adres'] ?>'><br>
                <label for="kara">Kara</label><br>
                <input type="text" name="kara" value='<?php if($row['kara'] != NULL) echo $row['kara']; else echo "0.0"; ?>'><br>
                <p style="color:red;"><?php echo $Message; ?></p>
                <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="update" value="Edytuj">
            </form>
        </div>
    </div>
  </body>
</html>
