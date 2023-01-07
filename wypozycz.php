<?php

include "db_conn.php"; 

$klient_id = $_GET['klient'];
$ksiazka_id = $_GET['ksiazka'];

date_default_timezone_get();
$data_wypozyczenia = date('Y-m-d', time());

$query = "SELECT k_name from klienci where klient_id='$klient_id'";
$result = $mysqli->query($query);
$row=mysqli_fetch_array($result);

$query_book = "SELECT tytul from ksiazki where ISBN='$ksiazka_id'";
$result_book = $mysqli->query($query_book);
$row_book=mysqli_fetch_array($result_book);

if(isset($_POST['accept'])) {
    //zmień status książki
    $query_wypozycz_ksiazki = "UPDATE ksiazki set status='niedostepna' where ISBN='$ksiazka_id'";
    $result_wypozycz_ksiazki = $mysqli->query($query_wypozycz_ksiazki);

    //dodaj rekord do wypożyczeń
    $query_w = "select count('1') from wypozyczenia";
    $result_w = $mysqli->query($query_w);
    $row_w=mysqli_fetch_array($result_w);
    $row_w[0] += 1;
    $query_dodaj_wypozyczenie = "INSERT INTO wypozyczenia (wypozyczenia_id, w_klient, w_data, w_isbn) VALUES ('$row_w[0]', '$klient_id', '$data_wypozyczenia', '$ksiazka_id')";
    $result_dodaj_wypozyczenie = $mysqli->query($query_dodaj_wypozyczenie);

    header("location:borrowed_books.php");
}

if(isset($_POST['cancel'])) {
    header("location: borrowed_books.php");
}

?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Wypożyczenie</title>
  </head>
  <body>
    
    <div class="card mx-auto border border-primary" style="width: 50%; text-align: center; margin-top: 15%;">
    <div class="card-body">
        <h5 class="card-title">Wypożyczenie książki</h5>
        <p><strong>Wypożyczający: </strong><?php echo $row['k_name']; ?></p>
        <p><strong>Książka: </strong><?php echo $row_book['tytul']; ?></p>
        <form action="wypozycz.php?klient=<?php echo $klient_id; ?>&ksiazka=<?php echo $ksiazka_id; ?>" method="post">
            <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="accept" value="Zatwierdź">
        </form><br>
        <form action="borrowed_books.php" method="post">
            <input class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="cancel" value="Anuluj">
        </form>
    </div>
    </div>
  </body>
</html>


