<?php
session_start();
include 'db_conn.php';
error_reporting(0);

$query = "SELECT filia_id FROM filia ORDER BY filia_id ASC";
$result = $mysqli->query($query);

$Message = $_GET['Message'];
if(isset($_POST['signup'])) {

    $username = $_POST['k_username'];
    $password = $_POST['k_password'];
    $name = $_POST['k_name'];
    $adres = $_POST['k_adres'];
    $filia = $_POST['filia'];
    date_default_timezone_get();
    $date = date('Y-m-d', time());
    if(empty($username) || empty($password) || empty($name) || empty($adres) || empty($filia)) {
        $Message = urlencode("Wszystkie pola musza byc wypelnione");
        header("Location:signup.php?Message=".$Message);
    }
    else {
        $query = "select count('1') from klienci";
        $result = $mysqli->query($query);
        $row=mysqli_fetch_array($result);
        $row[0] += 1;

        $query = "INSERT INTO klienci (klient_id, k_username, k_password, k_name, k_adres, data_rejestracji, kara, k_filia) VALUES ('$row[0]', '$username', '$password', '$name', '$adres', '$date', 0.0, '$filia')";
        $result = $mysqli->query($query);
        
        header("Location: index.php");
        
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
            <h3>Zarejestruj się</h3>
            <hr />
            <form action="signup.php" method="post">
                <label class="form-label" for="k_username">Nazwa użytkownika</label><br>
                <input class="form-control" type="text" name="k_username"><br>
                <label class="form-label" for="k_password">Hasło</label><br>
                <input class="form-control" type="password" name="k_password"><br>
                <label class="form-label" for="k_name">Imię i nazwisko</label><br>
                <input class="form-control" type="text" name="k_name"><br>
                <label class="form-label" for="k_adres">Adres</label><br>
                <input class="form-control" type="text" name="k_adres"><br>
                Wybierz filię: 
                <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="filia">
                <?php while($row = mysqli_fetch_array($result)):?>
                    <option value='<?php echo $row['filia_id'] ?>' <?php if ($_POST['filia_id'] == $row['filia_id']) echo 'selected="selected" '; ?>><?php echo $row['filia_id'] ?></option>
                <?php endwhile;?>
                </select><br><br>
                <p style="color:red;"><?php echo $Message; ?></p>
                <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="signup" value="Zarejestruj się">
            </form>
        </div>
    </span>
    </div>
  </body>
</html>
