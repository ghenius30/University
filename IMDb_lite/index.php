<?php session_start();?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/imdb_lite_ico.png" type="image/png">
    <title>IMDb Lite: A legjobb filmek és sorozatok</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <link rel="stylesheet" type="text/css" href="index_style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php"><img id="logo" src="img/imdb_blacklogo.png" title="Főoldal" alt="Főoldal" height="35" width="70"></a>
            <div class="lenyilo_menu">
                <img id="menu_button" src="img/menu_button.png" title="Menü" alt="Menü" height="25" width="25">
                <div class="menu_lista">
                    <ul id="mainmenu">
                        <li><a href="index.php" class="current">Főoldal</a></li>
                        <li><a href="movies.php">Filmek</a></li>
                        <li><a href="series.php">Sorozatok</a></li>
                        <li><a href="rolunk.php">Rólunk</a></li>
                    </ul>
                </div>
            </div>

            <div>
                <form method="get">
                    <label for="search_bar"><input id="search_bar" name="search" placeholder="Keresés" type="search"></label>
                    <input id="search_button" type="image" name="submit" title="Keresés" alt="Keresés gomb" src="https://cdn3.iconfinder.com/data/icons/unicons-vector-icons-pack/32/search-512.png" height="20" width="20">
                </form>
            </div>

            <div class="login-container">
                <?php if (isset($_SESSION["user"])) { ?>
                    <form action="logout.php" method="POST">
                        <?php if (isset($_SESSION["user"]) && $_SESSION["admin"]) { ?>
                        <button id="edit_button" type="submit" formaction="addMovies.php"  title="Hozzáadás">Hozzáadás</button>
                        <?php } ?>
                        <button id="logout_button" type="submit" title="Kijelentkezés">Kijelentkezés</button>
                    </form>
                    <?php echo "<p id='username_label'>Bejelentkezve mint <br><a>" . $_SESSION["user"] . "</a></p>"; ?>
                <?php } else { ?>
                    <form action="login.php" method="POST">
                        <span id="login-text">Bejelentkezés:</span>
                        <label for="username"><input id="username" type="text" placeholder="Felhasználónév" name="username" size="15" maxlength="15"></label>
                        <label for="pwd"><input id="pwd" type="password" placeholder="Jelszó" name="pwd" size="15" maxlength="20"></label>
                        <button id="login_button" type="submit" name="belepes" title="Belépés">Belépés</button>
                        <button id="reg_button" type="submit" formaction="register.php"  title="Regisztráció">Regisztráció</button>
                    </form>
                <?php }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <div class="slider-container">
            <div class="image-container">
                <span id="black-widow" class="slider-class">
                    <a href="https://www.youtube.com/embed/ybji16u608U"><img class="play-button" src="https://drcorinneweaver.com/wp-content/uploads/2018/05/transparent-play-button.png" title="Fekete Özvegy előzetes" alt="Fekete Özvegy előzetes" height="100" width="100"/></a>
                    <img class="slider-image" alt="Fekete Özvegy poszter" src="https://cdn.collider.com/wp-content/uploads/2020/03/black-widow-poster.jpg" height="480"/>
                    <a href="https://www.youtube.com/embed/ybji16u608U"><img class="slider-image" src="https://img.youtube.com/vi/ybji16u608U/maxresdefault.jpg" title="Fekete Özvegy előzetes" alt="Fekete Özvegy előzetes" height="480"/></a>
                </span>

                <span id="wonder-woman" class="slider-class">
                    <a href="https://www.youtube.com/embed/sfM7_JLk-84"><img class="play-button" src="https://drcorinneweaver.com/wp-content/uploads/2018/05/transparent-play-button.png" title="Wonder Woman 1984 előzetes" alt="Wonder Woman 1984 előzetes" height="100" width="100"/></a>
                    <img class="slider-image" alt="Wonder Woman 1984 poszter" src="https://static.posters.cz/image/750/plakatok/wonder-woman-1984-teaser-i83411.jpg" height="480"/>
                    <a href="https://www.youtube.com/embed/sfM7_JLk-84"><img class="slider-image" src="https://img.youtube.com/vi/sfM7_JLk-84/maxresdefault.jpg" title="Wonder Woman 1984 előzetes" alt="Wonder Woman 1984 előzetes" height="480"></a>
                </span>

                <span id="quietplace" class="slider-class">
                    <a href="https://www.youtube.com/embed/XEMwSdne6UE"><img class="play-button" src="https://drcorinneweaver.com/wp-content/uploads/2018/05/transparent-play-button.png" title="Hang nélkül 2 előzetes" alt="Hang nélkül 2 előzetes" height="100" width="100"/></a>
                    <img class="slider-image" alt="Hang nélkül 2 poszter" src="https://cdn.collider.com/wp-content/uploads/2019/12/a-quiet-place-part-2-teaser-poster.jpg" height="480"/>
                    <a href="https://www.youtube.com/embed/XEMwSdne6UE"><img class="slider-image" src="https://img.youtube.com/vi/XEMwSdne6UE/maxresdefault.jpg" title="Hang nélkül 2 előzetes" alt="Hang nélkül 2 előzetes" height="480"></a>
                </span>

                <span id="no-time-to-die" class="slider-class">
                    <a href="https://www.youtube.com/embed/BIhNsAtPbPI"><img class="play-button" src="https://drcorinneweaver.com/wp-content/uploads/2018/05/transparent-play-button.png" title="007 Nincs idő meghalni előzetes" alt="007 Nincs idő meghalni előzetes" height="100" width="100"/></a>
                    <img class="slider-image" alt="007 Nincs idő meghalni poszter" src="https://m.media-amazon.com/images/M/MV5BNGEwMDU2ZDQtZmE5Zi00YjFiLWIwYWItOGMyMzY5MzljOWU3XkEyXkFqcGdeQXVyODk2NDQ3MTA@._V1_.jpg" height="480"/>
                    <a href="https://www.youtube.com/embed/BIhNsAtPbPI"><img class="slider-image" src="https://img.youtube.com/vi/BIhNsAtPbPI/maxresdefault.jpg" title="007 Nincs idő meghalni előzetes" alt="007 Nincs idő meghalni előzetes" height="480"></a>
                </span>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-div">
            <hr>
            <p class="copyright-text">Copyright &copy; 2020 Minden jog fenntartva.
                <a href="index.php"> IMDb Lite </a>
            </p>
        </div>
    </footer>



</body>
</html>