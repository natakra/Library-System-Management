<?php
session_start();
include 'db_conn.php';
error_reporting(0);

$query = "SELECT * FROM pracownicy INNER JOIN filia on pracownicy.p_filia = filia.filia_id";
$search_result = $mysqli->query($query);

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM `pracownicy` WHERE CONCAT(`p_name`, `stanowisko`, `p_filia`) LIKE '%".$valueToSearch."%'";
    $search_result = $mysqli->query($query);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Inne biblioteki</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
    </head>
    <body>
    <?php require("navbar_admin.php"); ?>
    <div class="row justify-content-center" style="margin: 20px;">
        <div class="col-auto">
            <table class="table table-responsive border border-primary" style="text-align: center;">
                <tr>
                    <th>Imię i nazwisko</th>
                    <th>Stanowisko</th>
                    <th>Filia</th>
                    <th>Kontakt</th>
                </tr>
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['p_name'];?></td>
                    <td><?php echo $row['stanowisko'];?></td>
                    <td><?php echo $row['p_filia'];?></td>
                    <td><?php echo $row['f_kontakt'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </div>
    </div>
    </body>
</html>