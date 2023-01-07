<?php
session_start(); 
include "db_conn.php";
$Message = $_GET['Message'];

if(isset($_GET['Message'])){
    echo $_GET['Message'];
}

if (isset($_POST['login'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['k_username']);
    $pass = validate($_POST['k_password']);

    if (empty($uname)) {
        $Message = urlencode("Podaj nazwę użytkownika");
        $_SESSION['message'] = $Message;
        header("Location:index.php?Message=".$Message);
    

    }else if(empty($pass)){

        $Message = urlencode("Podaj hasło");
        header("Location:index.php?Message=".$Message);

    }else{

        $query = "SELECT * FROM klienci WHERE k_username='$uname' AND k_password='$pass'";

        $result = $mysqli->query($query);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['k_username'] === $uname && $row['k_password'] === $pass) {

                echo "Logged in!";
                $_SESSION['username'] = $row['k_username'];
                $_SESSION['id'] = $row['klient_id'];
                header("Location: home.php");

            }else{

                $Message = urlencode("Nieprawidłowa nazwa użytkownika lub hasło");
                header("Location:index.php?Message=".$Message);
            }

        }else{
            $Message = urlencode("Nieprawidłowa nazwa użytkownika lub hasło");
            header("Location:index.php?Message=".$Message);
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
    <link rel="stylesheet" href="styles/login-styles.css">

    <title>Biblioteka</title>
  </head>
  <body>
  <div class="back">
    <div class="div-center border border-primary">
    <div class="content">
        <h3>Login</h3>
        <hr />
        <form action="index.php" method="post">
                <label class="form-label" for="k_username">Nazwa użytkownika</label><br>
                <input class="form-control" type="text" name="k_username"><br>
                <label class="form-label" for="k_password">Hasło</label><br>
                <input class="form-control" type="password" name="k_password"><br><br>
                <p style="color:red;"><?php echo $Message; ?></p>
                <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="login" value="Zaloguj się">
            </form>
            <br><a href="signup.php">Załóż konto</a><br>
            <a href="admin_login.php">Zaloguj się jako pracownik</a>
        </div>
        </span>
    </div>
  </body>
</html>
