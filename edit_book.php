<?php

include "db_conn.php";
error_reporting(0);

$id = $_GET['id'];
$Message = $_GET['Message'];

$query = "select * from ksiazki where ISBN = '$id'";
$result = $mysqli->query($query);
$row=mysqli_fetch_array($result);

$query_status = "SELECT DISTINCT status FROM ksiazki";
$result_status = $mysqli->query($query_status);

if(isset($_POST['update']))
{
    $tytul = $_POST['tytul'];
    $autor = $_POST['autor'];
    $kategoria = $_POST['kategoria'];
    $status = $_POST['status'];
    $wydawca = $_POST['wydawca'];

    if(empty($tytul) || empty($autor) || empty($kategoria) || empty($status) || empty($wydawca)) {
        $Message = urlencode("Wszystkie pola musza byc wypelnione");
        header("Location:edit_book.php?Message=".$Message);
    }
    else {
        $query = "UPDATE ksiazki set tytul='$tytul', autor='$autor', kategoria='$kategoria', status='$status', wydawca='$wydawca' where ISBN = '$id'";
        $result = $mysqli->query($query);
        
        if ($mysqli->query($query) === TRUE) {
            header("location:admin_books.php");
        } 

        else {
            echo "Błąd " . $mysqli->error;
        }
        
    }	
}
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Edycja książki</title>
  </head>
  <body>
    
    <div class="card mx-auto border border-primary" style="width: 50%; text-align: center; margin-top: 10%;">
        <div class="card-body">
            <h5 class="card-title">Edycja książki</h5>
            <form action="edit_book.php?id=<?php echo $id; ?>" method="post">
                <label for="tytul">Tytuł</label><br>
                <input type="text" name="tytul" value='<?php echo $row['tytul'] ?>'><br>
                <label for="autor">Autor</label><br>
                <input type="text" name="autor" value='<?php echo $row['autor'] ?>'><br>
                <label for="kategoria">Kategoria</label><br>
                <input type="text" name="kategoria" value='<?php echo $row['kategoria'] ?>'><br>
                <label for="wydawca">Wydawca</label><br>
                <input type="text" name="wydawca" value='<?php echo $row['wydawca'] ?>'><br>
                <label for="status">Status</label><br>
                <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="status">
                    <?php while($row = mysqli_fetch_array($result_status)):?>
                        <option value='<?php echo $row['status'] ?>' <?php if ($_POST['status'] == $row['status']) echo 'selected="selected" '; ?>><?php echo $row['status'] ?></option>
                    <?php endwhile;?>
                </select><br><br>
                <p style="color:red;"><?php echo $Message; ?></p>
                <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="update" value="Edytuj">
            </form><br>
            <form action="admin_books.php" method="post">
                <input class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="cancel" value="Anuluj">
            </form>
        </div>
    </div>
  </body>
</html>
