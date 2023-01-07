<?php

session_start(); 
include "db_conn.php";
error_reporting(0);

$Message = $_GET['Message'];

if (isset($_POST['login'])) {

    $uname = $_POST['p_username'];
    $pass = $_POST['p_password'];

    if (empty($uname)) {
        $Message = urlencode("Podaj nazwę użytkownika");
        header("Location:admin_login.php?Message=".$Message);
    }

    else if(empty($pass)){
        $Message = urlencode("Podaj hasło");
        header("Location:admin_login.php?Message=".$Message);
    }
    
    else{

        $query = "SELECT * FROM pracownicy WHERE p_username='$uname' AND p_password='$pass'";
        $result = $mysqli->query($query);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['p_username'] === $uname && $row['p_password'] === $pass) {

                $_SESSION['username'] = $row['p_username'];
                $_SESSION['id'] = $row['p_id'];
                header("Location: admin_home.php");
            }
            
            else{
                $Message = urlencode("Nieprawidłowa nazwa użytkownika lub hasło");
                header("Location:admin_login.php?Message=".$Message);
            }

        }
        
        else{
            $Message = urlencode("Nieprawidłowa nazwa użytkownika lub hasło");
            header("Location:admin_login.php?Message=".$Message);
        }

    }

}
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/admin-login-styles.css">

    <title>Biblioteka</title>
  </head>
  <body>
  <div class="back">
        <div class="div-center border border-primary">
        <div class="content">
            <h3>Login</h3>
            <hr />
            <form action="admin_login.php" method="post">
                    <label class="form-label" for="p_username">Nazwa użytkownika</label><br>
                    <input class="form-control" type="text" name="p_username"><br>
                    <label class="form-label" for="p_password">Hasło</label><br>
                    <input class="form-control" type="password" name="p_password"><br><br>
                    <p style="color:red;"><?php echo $Message; ?></p>
                    <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="login" value="Zaloguj się">
                </form>
                <br><a href="signup.php">Załóż konto</a><br>
                <a href="index.php">Zaloguj się jako użytkownik</a>
        </div>
        </span>
    </div>
  </body>
</html>