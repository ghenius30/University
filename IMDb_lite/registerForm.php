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
        </nav>
    </header>
    <main>
        <?php if (isset($_POST["register-button"])) {
            if (empty($_POST["reg-username"])){?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> Adja meg a felhasználónevét!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            } else {
                $username = $_POST["reg-username"];
            }

            if (empty($_POST["email"])){?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> Adja meg az email címét!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            } else {
                $email = $_POST["email"];
            }

            if (empty($_POST["pwd1"])){?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> Adja meg a jelszavát!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            } else {
                $pwd1 = $_POST["pwd1"];
            }

            if (empty($_POST["pwd2"])){?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> Adja meg újra a jelszavát!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            } else {
                $pwd2 = $_POST["pwd2"];
            }

            if (empty($_POST["bdate"])){?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> Adja meg a születési dátumát!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            } else {
                $bdate = $_POST["bdate"];
                $birthyear = strtotime($bdate);
            }

            if (empty($_POST["chkbx"])){?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> Fiók létrehozásához el kell fogadnia a felhasználási feltételeket!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            }
            if ($pwd1 !== $pwd2) {?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> A két jelszónak meg kell egyeznie!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            }

            if (date("Y.md") - date("Y.md", $birthyear) < 14) {?>
                <div class="errormessage"><?php
                    header('Refresh:5;URL=register.php');
                    die('<b>HIBA:</b> Sajnáljuk, de csak 14 éves kortól regisztrálhat!
                    <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                </div><?php
            }

            // beolvasás fájlból
            $file = fopen("db/accounts.txt", "r");
            $accounts2 = [];
            while (($line = fgets($file)) !== false) {
                $accounts2[] = unserialize($line);
            }
            fclose($file);

            foreach ($accounts2 as $actualaccount) {
                if ($actualaccount["username"] === $username) {?>
                    <div class="errormessage"><?php
                        header('Refresh:5;URL=register.php');
                        die('<b>HIBA:</b> Ez a felhasználónév már foglalt!
                        <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                    </div><?php
                }
                if ($actualaccount["email"] === $email) {?>
                    <div class="errormessage"><?php
                        header('Refresh:5;URL=register.php');
                        die('<b>HIBA:</b> Ezzel az email címmel már regisztráltak!
                        <p class="nextpage-message">Hamarosan visszairányítunk a regisztrációs oldalra...</p>'); ?>
                    </div><?php
                }
                    }
            $accounts[] = ["username" => $username, "email" => $email, "password" => $pwd1];

            // kiíratás fájlba
            $file = fopen("db/accounts.txt", "a");
            foreach ($accounts as $actualaccount) {
                fwrite($file, serialize($actualaccount) . "\n");
            }
            fclose($file); ?>

            <div class="message">
                <span>Sikeres regisztráció <?php echo $username ?> néven!<br/> A folytatáshoz jelentkezzen be!</span>
                <p class="nextpage-message">Hamarosan átirányítunk a főoldalra...</p>
            </div>
            <?php header('Refresh:3;URL=index.php');
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