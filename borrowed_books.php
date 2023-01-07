<?php
session_start();
include 'db_conn.php';

$query = "SELECT wypozyczenia.wypozyczenia_id, klienci.k_name, klienci.klient_id, wypozyczenia.w_data, ksiazki.tytul, ksiazki.ISBN from wypozyczenia inner join klienci on wypozyczenia.w_klient=klienci.klient_id inner join ksiazki on wypozyczenia.w_isbn = ksiazki.ISBN ORDER BY wypozyczenia.wypozyczenia_id ASC";
$search_result = $mysqli->query($query);


if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT wypozyczenia.wypozyczenia_id, klienci.k_name, klienci.klient_id, wypozyczenia.w_data, ksiazki.tytul, ksiazki.ISBN from wypozyczenia inner join klienci on wypozyczenia.w_klient=klienci.klient_id inner join ksiazki on wypozyczenia.w_isbn = ksiazki.ISBN WHERE CONCAT(`wypozyczenia_id`, `k_name`, `w_data`, `tytul`) LIKE '%".$valueToSearch."%'";
    $search_result = $mysqli->query($query);
}

else {
    if(isset($_POST['wypozycz'])) {
        $book = $_POST["book_id"];
        $user = $_POST["k_id"];

        header("Location: wypozycz.php?klient=$user&ksiazka=$book");
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Obsługa</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
    </head>
    <body>

    <?php require("navbar_admin.php"); ?>
        
        <form action="borrowed_books.php" method="post" class="form-inline d-flex justify-content-center">
            <input type="text" name="valueToSearch" placeholder="Wyszukaj książkę" class="form-control" style="width: 75%; text-align:center; margin: 10px;">
            <input type="submit" name="search" value="Szukaj" class="btn btn-primary">
            <input type="submit" name="reset" value="Reset" class="btn btn-dark" style="margin: 10px;"><br><br>
        </form>
        <br>
        <div class="d-flex flex-row d-flex justify-content-around" style="margin: 5%;">
        <div class="p-2">
        <h5 style="text-align: center;">Wypożycz książkę</h5>
        <form action="borrowed_books.php" method="post" style="text-align: center; margin-left: 5%;">
            <label class="form-label" for="book_id">ISBN</label><br>
            <input class="form-control" type="text" name="book_id"><br>
            <label class="form-label" for="k_id">Id klienta</label><br>
            <input class="form-control" type="text" name="k_id"><br>
            <input type="submit" name="wypozycz" value="Wypożycz" class="btn btn-primary">
        </form>
        </div>
        <div class="p-2">
                <table class="table table-responsive border border-primary" style="text-align: center;">
                    <tr>
                        <th>Id</th>
                        <th>Klient</th>
                        <th>Data wypożyczenia</th>
                        <th>Książka</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($search_result)):?>
                    <tr>
                        <td><?php echo $row['wypozyczenia_id'];?></td>
                        <td><?php echo $row['k_name'];?></td>
                        <td><?php echo $row['w_data'];?></td>
                        <td><?php echo $row['tytul'];?></td>
                        <td><a href="zwrot.php?klient=<?php echo $row['klient_id']; ?>&ksiazka=<?php echo $row['ISBN']; ?>&id=<?php echo $row['wypozyczenia_id']; ?>">Zwróć</a></td>
                    </tr>
                    <?php endwhile;?>
                </table>
            </div>
        </div>
    </body>
</html>

