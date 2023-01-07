<?php
    include "db_conn.php";
    session_start();

    $id = $_SESSION["id"];

    $query = "select * from pracownicy where p_id = '$id'";
    $result = $mysqli->query($query);
    $row=mysqli_fetch_array($result);
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/admin-profile-styles.css">

    <title>Profil</title>
  </head>
  <body>
    <?php require("navbar_admin.php"); ?>
    <div class="page-content page-container" id="page-content">
        <div class="padding d-flex align-items-center justify-content-center">
            <div class="row container d-flex justify-content-center">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-card-full">
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-4 bg-c-lite-green user-profile">
                                <div class="card-block text-center text-white">
                                    <div class="m-b-6"> <img src="styles/images/librarian_icon.svg" class="img-radius" alt="User-Profile-Image"> </div>
                                    <h6 class="f-w-600"><?php echo $row['p_name']?></h6>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-block">
                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informacje</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Stanowisko</p>
                                            <h6 class="text-muted f-w-400"><?php echo $row['stanowisko']?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Filia</p>
                                            <h6 class="text-muted f-w-400"><?php echo $row['p_filia']?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>