<?php
   session_start();
   $user = $_SESSION["username"];
   $id = $_SESSION["id"];
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/admin-home-styles.css">

    <title>Witaj <?php echo $user;?></title>
  </head>
  <body>
    <?php require("navbar_admin.php"); ?>

    <div class="container">
        <div class="row">
            <div class="container">
                <blockquote class="quote-card">
                <p>
                    Mieszkanie bez książki ciemniejsze jest niż bez lampy.
                </p>
                <cite>
                    Henryk Sienkiewicz
                </cite>
                </blockquote>
            
            </div>
        </div>
    </div>
</body>
</html>