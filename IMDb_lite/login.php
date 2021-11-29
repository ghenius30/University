<?php session_start();?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/imdb_lite_ico.png" type="image/png">
    <title>IMDb Lite: Bejelentkezés</title>
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
        </nav>
    </header>
    <main><?php
        if (isset($_POST["belepes"])) {
            $accounts = [];
            $file = fopen("db/accounts.txt", "r");
            while (($line = fgets($file)) !== false) {
                $accounts[] = unserialize($line);
            }
            fclose($file);

            if (empty($_POST["username"])) {?>
                <div class="errormessage"><?php
                header('Refresh:2;URL=index.php');
                die('<b>HIBA:</b> Adja meg a felhasználónevét!
                            <p class="nextpage-message">Hamarosan átirányítunk a főoldalra...</p>'); ?>
                </div><?php
            } else {
                $username = $_POST["username"];
            }

            if (empty($_POST["pwd"])) {?>
                <div class="errormessage"><?php
                header('Refresh:2;URL=index.php');
                die('<b>HIBA:</b> Adja meg a jelszavát!
                            <p class="nextpage-message">Hamarosan átirányítunk a főoldalra...</p>'); ?>
                </div><?php
            } else {
                $pwd = $_POST["pwd"];
            }

            if (empty($accounts)) {
                header("Location: register.php");
            } else {
                foreach ($accounts as $acc) {
                    if ($acc["username"] === $username && $acc["password"] === $pwd) {
                        $_SESSION["user"] = $username;

                        if ($acc["username"] === "admin" && $acc["password"] === "admin") {
                            $_SESSION["admin"] = TRUE;
                        } else {
                            $_SESSION["admin"] = FALSE;
                        } ?>
                        <div class="message">
                                <span>Sikeres bejelentkezés <?php echo $_SESSION["user"] ?> néven! <br/>
                                    <p class="nextpage-message">Hamarosan átirányítunk a főoldalra...</p>
                                </span>
                        </div>
                        <?php header('Refresh:2;URL=index.php');
                        exit();
                        break;
                    }
                }
                foreach ($accounts as $acc) {
                    if ($acc["username"] !== $username && $acc["password"] !== $pwd) {?>
                        <div class="errormessage"><?php
                        header('Refresh:5;URL=register.php');
                        die('<b>HIBA:</b> Nincs ilyen felhasználói fiók!<br/>
                                        <p>Győzödjön meg róla helyesen írta-e be a felhasználónevét és a jelszavát!</p>
                                        <p>Ha még nincs felhasználói fiókja regisztráljon!</p>
                                    <p class="nextpage-message">Hamarosan átirányítunk a regisztrációs oldalra...</p>');?>
                        </div><?php
                    }
                }
            }
        }?>
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