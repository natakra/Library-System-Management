<?php
session_start();
include 'db_conn.php';
error_reporting(0);

$query = "SELECT * FROM `ksiazki`";
$search_result = $mysqli->query($query);

$query = "SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC";
$result = $mysqli->query($query);

$query = "SELECT DISTINCT status FROM ksiazki ORDER BY status ASC";
$result_status = $mysqli->query($query);

$query = "SELECT DISTINCT autor FROM ksiazki ORDER BY autor ASC";
$result_autor = $mysqli->query($query);

$query = "SELECT DISTINCT wydawca FROM ksiazki ORDER BY wydawca ASC";
$result_wydawca = $mysqli->query($query);

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM `ksiazki` WHERE CONCAT(`ISBN`, `tytul`, `kategoria`, `status`, `autor`, `wydawca`) LIKE '%".$valueToSearch."%'";
    $search_result = $mysqli->query($query);
    
}
 else {
    if(isset($_POST['kategoria'])) {
        $kategoria = $_POST["kategoria"];
        $sql = "SELECT ISBN, tytul, kategoria, status, autor, wydawca FROM ksiazki where kategoria = '$kategoria'";
        $search_result = $mysqli->query($sql);
        if ($search_result->num_rows <= 0) {
            $query = "SELECT * FROM `ksiazki`";
            $search_result = $mysqli->query($query);
        }
    }

    if(isset($_POST['status'])) {
        $status = $_POST["status"];
        $sql = "SELECT ISBN, tytul, kategoria, status, autor, wydawca FROM ksiazki where status = '$status'";
        $search_result = $mysqli->query($sql);
        if ($search_result->num_rows <= 0) {
            $query = "SELECT * FROM `ksiazki`";
            $search_result = $mysqli->query($query);
        }
    }

    if(isset($_POST['autor'])) {
        $autor = $_POST["autor"];
        $sql = "SELECT ISBN, tytul, kategoria, status, autor, wydawca FROM ksiazki where autor = '$autor'";
        $search_result = $mysqli->query($sql);
        if ($search_result->num_rows <= 0) {
            $query = "SELECT * FROM `ksiazki`";
            $search_result = $mysqli->query($query);
        }
    }

    if(isset($_POST['wydawca'])) {
        $wydawca = $_POST["wydawca"];
        $sql = "SELECT ISBN, tytul, kategoria, status, autor, wydawca FROM ksiazki where wydawca = '$wydawca'";
        $search_result = $mysqli->query($sql);
        if ($search_result->num_rows <= 0) {
            $query = "SELECT * FROM `ksiazki`";
            $search_result = $mysqli->query($query);
        }
    }

    if(isset($_POST['reset'])) {
        header("Location: books.php");
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Książki</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>

    <?php require("navbar.php"); ?>
        
        <form action="books.php" method="post" class="form-inline d-flex justify-content-center">
            <input type="text" name="valueToSearch" placeholder="Wyszukaj książkę" class="form-control" style="width: 75%; text-align:center; margin: 10px;">
            <input type="submit" name="search" value="Szukaj" class="btn btn-primary">
            <input type="submit" name="reset" value="Reset" class="btn btn-dark" style="margin: 10px;"><br><br>
        </form>
        <div class="d-flex flex-row justify-content-center">
            <div class="p-2">
            <form method="POST" action="">
            Kategoria: 
            <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="kategoria" onchange="this.form.submit()">
                <option value="" selected>wszystkie</option>
                <?php while($row = mysqli_fetch_array($result)):?>
                    <option value='<?php echo $row['kategoria'] ?>' <?php if ($_POST['kategoria'] == $row['kategoria']) echo 'selected="selected" '; ?>><?php echo $row['kategoria'] ?></option>
                <?php endwhile;?>
            </select>
            </form>
        </div>
        <div class="p-2">
            <form method="POST" action="">
            Autora: 
            <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="autor" onchange="this.form.submit()">
                <option value="" selected>wszystkie</option>
                <?php while($row = mysqli_fetch_array($result_autor)):?>
                    <option value='<?php echo $row['autor'] ?>' <?php if ($_POST['autor'] == $row['autor']) echo 'selected="selected" '; ?>><?php echo $row['autor'] ?></option>
                <?php endwhile;?>
            </select>
            </form>
        </div>
        <div class="p-2">
            <form method="POST" action="">
            Wybierz wydawcę: 
            <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="wydawca" onchange="this.form.submit()">
                <option value="" selected>wszystkie</option>
                <?php while($row = mysqli_fetch_array($result_wydawca)):?>
                    <option value='<?php echo $row['wydawca'] ?>' <?php if ($_POST['wydawca'] == $row['wydawca']) echo 'selected="selected" '; ?>><?php echo $row['wydawca'] ?></option>
                <?php endwhile;?>
            </select>
            </form>
            </div>
            <div class="p-2">
                <form method="POST" action="">
                Status: 
                <select class="btn btn-outline-secondary dropdown-toggle border border-primary" name="status" onchange="this.form.submit()">
                    <option value="" selected>wszystkie</option>
                <?php while($row = mysqli_fetch_array($result_status)):?>
                    <option value='<?php echo $row['status'] ?>' <?php if ($_POST['status'] == $row['status']) echo 'selected="selected" '; ?>><?php echo $row['status'] ?></option>
                <?php endwhile;?>
            </select>
            </form>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-auto">
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
                    </tr>
                    <?php endwhile;?>
                </table>
            </div>
        </div>
    </body>
</html>