<?php
session_start();
include 'db_conn.php';
error_reporting(0);

$query = "SELECT filia_id FROM filia ORDER BY filia_id ASC";
$result = $mysqli->query($query);

$query_users = "SELECT * FROM klienci INNER JOIN filia on klienci.k_filia = filia.filia_id";
$users_result = $mysqli->query($query_users);

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];

    $query = "SELECT * FROM `klienci` WHERE CONCAT(`k_name`) LIKE '%".$valueToSearch."%'";
    $search_result = $mysqli->query($query);
    if ($search_result->num_rows <= 0) {
        $query = "SELECT * FROM `klienci`";
        $search_result = $mysqli->query($query); 
    }
    
}

else {
    if(isset($_POST['add'])) {

        $username = $_POST['k_username'];
        $password = $_POST['k_password'];
        $name = $_POST['k_name'];
        $adres = $_POST['k_adres'];
        $filia = $_POST['filia'];
        date_default_timezone_get();
        $date = date('Y-m-d', time());
        if(empty($username) || empty($password) || empty($name) || empty($adres) || empty($filia)) {
            echo "Żadne pole nie może być puste!";
        }
        else {
            $query = "select count('1') from klienci";
            $result = $mysqli->query($query);
            $row=mysqli_fetch_array($result);
            $row[0] += 1;
    
            $query = "INSERT INTO klienci (klient_id, k_username, k_password, k_name, k_adres, data_rejestracji, kara, k_filia) VALUES ('$row[0]', '$username', '$password', '$name', '$adres', '$date', 0.0, '$filia')";
            $result = $mysqli->query($query);
            
            echo "Użytkownik został dodany";
            header("Location: users.php");
            
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Użytkownicy</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
    </head>
    <body>

    <?php require("navbar_admin.php"); ?>
    <div class="d-flex flex-row d-flex justify-content-around" style="margin: 5%;">
    <div class="p-2">
        <form action="users.php" method="post" style="text-align: center; margin-left: 5%;">
            <label class="form-label" for="k_username">Nazwa użytkownika</label><br>
            <input class="form-control" type="text" name="k_username"><br>
            <label class="form-label" for="k_password">Hasło</label><br>
            <input class="form-control" type="password" name="k_password"><br>
            <label class="form-label" for="k_name">Imię i nazwisko</label><br>
            <input class="form-control" type="text" name="k_name"><br>
            <label class="form-label" for="k_adres">Adres</label><br>
            <input class="form-control" type="text" name="k_adres"><br><br>
            Filia: 
            <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="filia">
            <?php while($row = mysqli_fetch_array($result)):?>
                <option value='<?php echo $row['filia_id'] ?>' <?php if ($_POST['filia_id'] == $row['filia_id']) echo 'selected="selected" '; ?>><?php echo $row['filia_id'] ?></option>
            <?php endwhile;?>
            </select><br><br>
            <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="add" value="Dodaj użytkownika">
        </form>
    </div>
    <div class="p-2">
        <table class="table table-responsive border border-primary" style="text-align: center;">
            <tr>
                <th>Id</th>
                <th>Imię i nazwisko</th>
                <th>Adres</th>
                <th>Data rejestracji</th>
                <th>Kara</th>
                <th>Filia</th>
            </tr>
            <?php while($row = mysqli_fetch_array($users_result)):?>
            <tr>
                <td><?php echo $row['klient_id'];?></td>
                <td><?php echo $row['k_name'];?></td>
                <td><?php echo $row['k_adres'];?></td>
                <td><?php echo $row['data_rejestracji'];?></td>
                <td><?php echo $row['kara'];?></td>
                <td><?php echo $row['k_filia'];?></td>
                <td><a href="edit_user.php?id=<?php echo $row['klient_id']; ?>">Edit</a></td>
                <td><a href="delete_user.php?id=<?php echo $row['klient_id']; ?>">Delete</a></td>
            </tr>
            <?php endwhile;?>
        </table>
    </div>
    </div>
    </body>
</html>
