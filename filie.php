<?php
session_start();
include 'db_conn.php';
error_reporting(0);

$query = "SELECT * FROM `filia`";
$search_result = $mysqli->query($query);

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM `filia` WHERE CONCAT(`filia_id`, `f_adres`, `f_miasto`, `f_kod`, `f_kontakt`) LIKE '%".$valueToSearch."%'";
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
    <?php require("navbar.php"); ?>
        <div class="row justify-content-center" style="margin: 20px;">
            <div class="col-auto">
                <table class="table table-responsive border border-primary" style="text-align: center;">
                    <tr>
                        <th>Numer</th>
                        <th>Adres</th>
                        <th>Miasto</th>
                        <th>Telefon</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($search_result)):?>
                    <tr>
                        <td><?php echo $row['filia_id'];?></td>
                        <td><?php echo $row['f_adres'];?></td>
                        <td><?php echo $row['f_miasto'];?></td>
                        <td><?php echo $row['f_kontakt'];?></td>
                    </tr>
                    <?php endwhile;?>
                </table>
            </div>
        </div>
    </body>
</html>