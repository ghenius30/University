<?php session_start();?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/imdb_lite_ico.png" type="image/png">
    <title>IMDb Lite: Regisztráció</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <link rel="stylesheet" type="text/css" href="register_style.css">

</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php"><img id="logo" src="img/imdb_blacklogo.png" title="Főoldal" alt="Főoldal" height="35" width="70"></a>
            <div class="lenyilo_menu">
                <img id="menu_button" src="img/menu_button.png" title="Menü" alt="Menü" height="25" width="25">
                <div class="menu_lista">
                    <ul id="mainmenu">
                        <li><a href="index.php">Főoldal</a></li>
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
                    </form>
                <?php }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <?php if (!(isset($_SESSION["user"]))) { ?>
        <div class="register-form">
            <form action="registerForm.php" method="post">
                <fieldset>
                    <legend>Regisztráció</legend>

                    <label for="reg-username">Felhasználónév</label><br/>
                    <input type="text" id="reg-username" name="reg-username" size="30" maxlength="15" required/><br/>

                    <label for="email">Email cím</label><br/>
                    <input type="email" id="email" name="email" size="30" maxlength="40" required/><br/>

                    <label for="pwd1">Jelszó</label><br/>
                    <input type="password" id="pwd1" name="pwd1" size="30" minlength="8" maxlength="20" placeholder="legalább 8 karakter" required/><br/>

                    <label for="pwd2">Jelszó újra</label><br/>
                    <input type="password" id="pwd2" name="pwd2" size="30" minlength="8" maxlength="20" placeholder="legalább 8 karakter" required/><br/>

                    <label for="bdate">Születési dátum</label><br/>
                    <input type="date" id="bdate" name="bdate" required/><br/>

                    <label for="chkbx" id="chkbx_lab">A felhasználási feltételeket elfogadom: </label>
                    <input type="checkbox" id="chkbx" name="chkbx" required/><br/>

                    <button id="register-button" type="submit" name="register-button">Fiók létrehozása</button>

                </fieldset>
            </form>
        </div>
        <?php } else if (isset($_SESSION["user"])) { ?>
            <div class="message">
                <span>Már regisztrálva vagy <?php echo $_SESSION["user"] ?> néven!</span>
                <p class="nextpage-message">Hamarosan átirányítunk a főoldalra...</p>
            </div>
            <?php header('Refresh:5;URL=index.php');
        }
        ?>
        <?php ?>
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