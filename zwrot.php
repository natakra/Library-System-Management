<?php

include "db_conn.php"; 

$klient_id = $_GET['klient'];
$ksiazka_id = $_GET['ksiazka'];
$id = $_GET['id'];

date_default_timezone_get();
$data_zwrotu = date('Y-m-d', time());

$kara = 0.0;
$kara_final = 0.0;

$query = "SELECT k_name from klienci where klient_id='$klient_id'";
$result = $mysqli->query($query);
$row=mysqli_fetch_array($result);

$query_book = "SELECT tytul from ksiazki where ISBN='$ksiazka_id'";
$result_book = $mysqli->query($query_book);
$row_book=mysqli_fetch_array($result_book);

$query_wypozyczenie = "SELECT w_data from wypozyczenia where wypozyczenia_id='$id'";
$result_wypozyczenie = $mysqli->query($query_wypozyczenie);
$row_wypozyczenie=mysqli_fetch_array($result_wypozyczenie);

$days = (strtotime($data_zwrotu) - strtotime($row_wypozyczenie['w_data']))/60/60/24;

if($days > 30) {
    $kara = round(($days - 30) * 0.10,2); //10 groszy za jeden dzień spóźnienia

    $query_get_kara = "SELECT kara from klienci where klient_id='$klient_id'";
    $result_get_kara = $mysqli->query($query_get_kara);
    $row_get_kara=mysqli_fetch_array($result_get_kara);

    $kara_final = $row_get_kara['kara'] + $kara;

}

if(isset($_POST['accept'])) {
    //dodaj karę do klienta
    $query_kara = "UPDATE klienci set kara='$kara_final' where klient_id='$klient_id'";
    $result_kara = $mysqli->query($query_kara);

    //zmień status książki
    $query_zwrot_ksiazki = "UPDATE ksiazki set status='dostepna' where ISBN='$ksiazka_id'";
    $result_zwrot_ksiazki = $mysqli->query($query_zwrot_ksiazki);

    //dodaj rekord wypożyczeń do panelu zwroty
    $query_z = "select count('1') from zwrot";
    $result_z = $mysqli->query($query_z);
    $row_z=mysqli_fetch_array($result_z);
    $query_dodaj_zwrot = "INSERT INTO zwrot (zwrot_id, z_klient, z_data, z_isbn) VALUES ('$row_z[0]', '$klient_id', '$data_zwrotu', '$ksiazka_id')";
    $result_dodaj_zwrot = $mysqli->query($query_dodaj_zwrot);

    //usuń rekord z wypożyczeń
    $query_del = "DELETE FROM wypozyczenia where wypozyczenia_id = '$id'";
    $result_del = $mysqli->query($query_del);
    if ($mysqli->query($query_del) === TRUE) {
        header("location:borrowed_books.php");
    } 
    else echo "Błąd: " . $mysqli->error;

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

    <title>Zwrot</title>
  </head>
  <body>
    <div class="card mx-auto border border-primary" style="width: 50%; text-align: center; margin-top: 15%;">
        <div class="card-body">
            <h5 class="card-title">Zwrot książki</h5>
            <p><strong>Oddający: </strong><?php echo $row['k_name']; ?></p>
            <p><strong>Książka: </strong><?php echo $row_book['tytul']; ?></p>
            <p><strong>Do zapłaty: </strong><?php echo $kara;?></p>
            <form action="zwrot.php?klient=<?php echo $klient_id; ?>&ksiazka=<?php echo $ksiazka_id; ?>&id=<?php echo $id; ?>" method="post">
                <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="accept" value="Zatwierdź">
            </form><br>
            <form action="borrowed_books.php" method="post">
                <input class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="cancel" value="Anuluj">
            </form>
        </div>
    </div>
  </body>
</html>


