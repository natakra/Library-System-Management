<?php

session_start();
include 'db_conn.php';

$user = $_SESSION["username"];
$id = $_SESSION["id"];

$num = 0;

$query = "SELECT zwrot.zwrot_id, zwrot.z_data, ksiazki.tytul from zwrot inner join (select * from klienci where klient_id='$id') klienci on zwrot.z_klient=klienci.klient_id inner join ksiazki on zwrot.z_isbn = ksiazki.ISBN ORDER BY zwrot.z_data ASC";
$search_result = $mysqli->query($query);

?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Historia wypożyczeń</title>
  </head>
  <body>
    <?php require("navbar.php"); ?>

    <h4 style="text-align: center; margin: 20px;">Historia wypożyczeń</h4>
    <div class="row justify-content-center">
      <div class="col-auto">
          <table class="table table-responsive border border-primary" style="text-align: center;">
              <tr>
                  <th>Id</th>
                  <th>Data</th>
                  <th>Książka</th>
              </tr>
              <?php while($row = mysqli_fetch_array($search_result)):?>
              <tr>
                  <td><?php $num++; echo $num;?></td>
                  <td><?php echo $row['z_data'];?></td>
                  <td><?php echo $row['tytul'];?></td>
              </tr>
              <?php endwhile;?>
          </table>
      </div>
    </div>
  </body>
</html>