<?php

session_start();
include 'db_conn.php';
error_reporting(0);

$Message = $_GET['Message'];

$query_status = "SELECT DISTINCT status FROM ksiazki ORDER BY status ASC";
$result_status = $mysqli->query($query_status);

$query = "SELECT * FROM `ksiazki`";
$search_result = $mysqli->query($query);

if(isset($_POST['add']))
{
    $tytul = $_POST['tytul'];
    $autor = $_POST['autor'];
    $kategoria = $_POST['kategoria'];
    $status = $_POST['status'];
    $wydawca = $_POST['wydawca'];
    if(empty($tytul) || empty($autor) || empty($kategoria) || empty($status) || empty($wydawca)) {
        $Message = urlencode("Wszystkie pola musza byc wypelnione");
        header("Location:admin_books.php?Message=".$Message);
    }
    else {
        $query = "select count('1') from ksiazki";
        $result = $mysqli->query($query);
        $row=mysqli_fetch_array($result);

        $query = "INSERT INTO ksiazki (ISBN, tytul, kategoria, status, autor, wydawca) VALUES ('$row[0]', '$tytul', '$kategoria', '$status', '$autor', '$wydawca')";
        $result = $mysqli->query($query);
        
        $query = "select * from ksiazki";
        $search_result = $mysqli->query($query);
        
    }
    
}
 else {
    $query = "SELECT * FROM `ksiazki`";
    $search_result = $mysqli->query($query);
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Książki</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
    </head>
    <body>

    <?php require("navbar_admin.php"); ?>
    <div class="d-flex flex-row d-flex justify-content-around" style="margin: 5%;">
    <div class="p-2">
        <form action="admin_books.php" method="post" style="text-align: center; margin-left: 5%;">
            <label class="form-label" for="tytul">Tytuł</label><br>
            <input class="form-control" type="text" name="tytul"><br>
            <label class="form-label" for="autor">Autor</label><br>
            <input class="form-control" type="text" name="autor"><br>
            <label class="form-label" for="kategoria">Kategoria</label><br>
            <input class="form-control" type="text" name="kategoria"><br>
            <label class="form-label" for="wydawca">Wydawca</label><br>
            <input class="form-control" type="text" name="wydawca"><br>
            <label class="form-label" for="status">Status</label><br>
            <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="status">
                <?php while($row = mysqli_fetch_array($result_status)):?>
                    <option value='<?php echo $row['status'] ?>' <?php if ($_POST['status'] == $row['status']) echo 'selected="selected" '; ?>><?php echo $row['status'] ?></option>
                <?php endwhile;?>
                </select><br><br>
                <p style="color:red;"><?php echo $Message; ?></p>
            <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="add" value="Dodaj">
        </form>
    </div>
    <div class="p-2">
    <table class="table table-responsive border border-primary" style="text-align: center;">
        <tr>
            <th>ISBN</th>
            <th>Tytuł</th>
            <th>Kategoria</th>
            <th>Status</th>
            <th>Autor</th>
            <th>Wydawca</th>
        </tr>
        
        <?php while($row = mysqli_fetch_array($search_result)):?>
        <tr>
        <td><?php echo $row['ISBN'];?></td>
        <td><?php echo $row['tytul'];?></td>
        <td><?php echo $row['kategoria'];?></td>
        <td><?php echo $row['status'];?></td>
        <td><?php echo $row['autor'];?></td>
        <td><?php echo $row['wydawca'];?></td>
        <td><a href="edit_book.php?id=<?php echo $row['ISBN']; ?>">Edit</a></td>
        <td><a href="delete_book.php?id=<?php echo $row['ISBN']; ?>">Delete</a></td>
        </tr>
        <?php endwhile;?>
    </table>
    </div>
    </div>
    </body>
</html>

