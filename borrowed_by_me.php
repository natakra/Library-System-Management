<?php

session_start();
include 'db_conn.php';

$user = $_SESSION["username"];
$id = $_SESSION["id"];

date_default_timezone_get();
$dzisiaj = date('Y-m-d', time());

$num = 0;

$query = "SELECT wypozyczenia.wypozyczenia_id, wypozyczenia.w_data, ksiazki.tytul from wypozyczenia inner join (select * from klienci where klient_id='$id') klienci on wypozyczenia.w_klient=klienci.klient_id inner join ksiazki on wypozyczenia.w_isbn = ksiazki.ISBN ORDER BY wypozyczenia.w_data DESC";
$search_result = $mysqli->query($query);

?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Moje wypożyczenia</title>
  </head>
  <body>
    <?php require("navbar.php"); ?>

    <h4 style="text-align: center; margin: 20px;">Moje wypożyczenia:</h4>
    <div class="row justify-content-center">
        <div class="col-auto">
            <table class="table table-responsive border border-primary" style="text-align: center;">
                <tr>
                    <th>Id</th>
                    <th>Data</th>
                    <th>Książka</th>
                    <th>Czas na zwrot</th>
                </tr>
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php $num++; echo $num;?></td>
                    <td><?php echo $row['w_data'];?></td>
                    <td><?php echo $row['tytul'];?></td>
                    <td><?php if(((strtotime($dzisiaj) - strtotime($row['w_data']))/60/60/24) > 30) echo "Zwróć książkę jak najszybciej!"; else echo "Zostało Ci jeszcze " . strval(30 - (strtotime($dzisiaj) - strtotime($row['w_data']))/60/60/24) . " dni";?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </div>
      </div>
  </body>
</html>