<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="styles/images/logo.svg" width="30" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="home.php">Strona główna<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="books.php">Książki</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="borrowed_by_me.php">Aktualnie wypożyczone</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="history.php">Historia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="filie.php">Filie</a>
        </li>
        </ul>
        <form action="profile.php?pracownik=<?php echo $id;?>" method="post" class="form-inline my-2 my-lg-0">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="profile"><?php echo $_SESSION["username"]?></button>
        </form>
        <form action="logout.php" method="post" class="form-inline my-2 my-lg-0" style="margin: 10px;">
        <button class="btn btn-outline-dark my-2 my-sm-0" type="logout">Wyloguj</button>
        </form>
    </div>
</nav>