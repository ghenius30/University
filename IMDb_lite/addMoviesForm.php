<?php session_start();?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/imdb_lite_ico.png" type="image/png">
    <title>Filmek és sorozatok hozzáadása</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <link rel="stylesheet" type="text/css" href="addMovies.css">
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
                <?php if (isset($_SESSION["user"])) {?>
                    <form action="logout.php" method="POST">
                        <button id="logout_button" type="submit" title="Kijelentkezés">Kijelentkezés</button>
                    </form>
                    <?php echo "<p id='username_label'>Bejelentkezve mint <br><a>" . $_SESSION["user"] . "</a></p>";
                }?>
            </div>
        </nav>
    </header>

    <main><?php
        if (isset($_SESSION["user"]) && $_SESSION["admin"]) {
            if (isset($_POST["save-button"])) {
                if (empty($_POST["media_type"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Válassza ki, hogy filmet vagy sorozatot akar feltölteni!
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $media_type = $_POST["media_type"];
                    $media_type_txt = ($media_type === "series") ? "sorozat" : "film";
                }

                if (empty($_POST["picURL"]) && empty($_FILES["picSRC"]["name"])){?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Töltsön fel legalább egy képet vagy adja meg az URL címét!<br/>
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php

                } else if (!(empty($_POST["picURL"])) && !(empty($_FILES["picSRC"]["name"]))){?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Csak egy elérési utat adjon meg!<br/>
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php

                } else if (!(empty($_POST["picURL"]))) {
                    if (preg_match("/^(https:\/{2})(.*)/", $_POST["picURL"])) {
                        $picURL = $_POST["picURL"];
                        $picSRC = "";
                    } else {?>
                        <div class="errormessage"><?php
                        header('Refresh:5;URL=addMovies.php');
                        die('<b>HIBA:</b> Helytelen kép url címet adott meg! Az url cím "https://" kezdetű legyen!
                                <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                        </div><?php
                    }

                } else if (!(empty($_FILES["picSRC"]["name"]))) {
                    $valid_kiterjesztes = ["jpg", "jpeg", "png"];
                    $kiterjesztes = pathinfo($_FILES["picSRC"]["name"], PATHINFO_EXTENSION);

                    if (in_array($kiterjesztes, $valid_kiterjesztes)) {
                        if ($_FILES["picSRC"]["error"] === 0) {
                            if ($_FILES["picSRC"]["size"] < 4000000) {
                                if ($media_type === "series") {
                                    $dest = "img/series/" . $_FILES["picSRC"]["name"];

                                } else if ($media_type === "movies") {
                                    $dest = "img/movies/" . $_FILES["picSRC"]["name"];
                                }
                                move_uploaded_file($_FILES["picSRC"]["tmp_name"], $dest);
                                $picSRC = $dest;
                                $picURL = "";
                            } else { ?>
                                <div class="errormessage"><?php
                                header('Refresh:5;URL=addMovies.php');
                                die('<b>HIBA:</b> A fájl mérete túl nagy!
                                        <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                                </div><?php
                            }
                        } else { ?>
                            <div class="errormessage"><?php
                            header('Refresh:5;URL=addMovies.php');
                            die('<b>HIBA:</b> Hiba történt a fájl feltöltése közben!<br/>Próbálja újra!</br>
                                    <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                            </div><?php
                        }
                    } else { ?>
                        <div class="errormessage"><?php
                        header('Refresh:5;URL=addMovies.php');
                        die('<b>HIBA:</b> A fájl kiterjesztése nem megfelelő!</br>
                                <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                        </div><?php
                    }
                }
                if (empty($_POST["title"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Adja meg a ' . $media_type_txt . ' címét!</br>
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $title = $_POST["title"];
                }

                if (empty($_POST["trailerURL"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Adja meg a ' . $media_type_txt . ' előzetesének URL címét!</br>
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php

                } else if (!empty($_POST["trailerURL"])) {
                    if (preg_match("/^(https:\/{2})(.*)/", $_POST["trailerURL"])) {
                        $trailerURL = $_POST["trailerURL"];
                    } else {?>
                        <div class="errormessage"><?php
                        header('Refresh:5;URL=addMovies.php');
                        die('<b>HIBA:</b> Helytelen ' . $media_type_txt . ' url címet adott meg!<br/> Az url cím "https://" kezdetű legyen!
                                <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                        </div><?php
                    }
                }
                if (empty($_POST["director"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Meg kell adnia a rendezőt!
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $director = $_POST["director"];
                }

                if (empty($_POST["producer"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Meg kell adnia a producert!
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $producer = $_POST["producer"];
                }

                if (empty($_POST["genre"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Meg kell adnia legalább egy műfajt!
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $genre = $_POST["genre"];
                }

                if (empty($_POST["story"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Meg kell adnia a forgatókönyvírót!
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $story = $_POST["story"];
                }

                if (empty($_POST["actors"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Meg kell adnia legalább egy főszereplőt!
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $actors = $_POST["actors"];
                }

                if (empty($_POST["release"])) { ?>
                    <div class="errormessage"><?php
                    header('Refresh:5;URL=addMovies.php');
                    die('<b>HIBA:</b> Meg kell adnia a megjelenés dátumát!
                            <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>'); ?>
                    </div><?php
                } else {
                    $release_date = strtotime($_POST["release"]);
                    $release_month = date("m", $release_date);
                    $month = which_month($release_month);
                    $release = date("Y. ", $release_date) . $month . date(" d.", $release_date);
                }

                $dataID = [];
                $file = fopen("db/mediadata.txt", "r");
                while (($line = fgets($file)) !== false) {
                    $dataID[] = unserialize($line);
                }
                fclose($file);

                if (empty($dataID)) {
                    $ID = 1;
                } else if (!(empty($dataID))) {
                    foreach ($dataID as $datatype) {
                        foreach ($datatype as $actualid) {
                            $ID = $actualid["ID"];
                            $ID = ++$ID;
                        }
                    }
                }

                if ($media_type === "movies") {
                    $media[] = ["movies"=>["ID"=>$ID,"title" => $title, "picURL" => $picURL, "picSRC" => $picSRC, "trailerURL" => $trailerURL, "director" => $director,
                        "producer" => $producer, "genre" => $genre, "story" => $story, "actors" => $actors, "release" => $release]];
                } else if ($media_type === "series") {
                    $media[] = ["series"=>["ID"=>$ID,"title" => $title, "picURL" => $picURL, "picSRC" => $picSRC, "trailerURL" => $trailerURL, "director" => $director,
                        "producer" => $producer, "genre" => $genre, "story" => $story, "actors" => $actors, "release" => $release]];
                }

                // kiíratás fájlba
                $file = fopen("db/mediadata.txt", "a");
                foreach ($media as $actualmedia) {
                    fwrite($file, serialize($actualmedia) . "\n");
                }
                fclose($file);?>

                <div class="message">
                    <span>Sikeres fájl feltöltés!</span>
                    <p class="nextpage-message">Hamarosan visszairányítunk az előző oldalra...</p>
                </div>
                <?php header('Refresh:2;URL=addMovies.php');
            }
        } else { ?>
            <div class="errormessage">
                    <span>Sajnáljuk, ez az oldal csak Admin jogosultságú felhasználóknak érhetők el! <br/>
                    Ha még nincs felhasználói fiókod regisztrálj vagy jelentkezz be!</span>
                <p class="nextpage-message">Hamarosan átirányítunk a főoldalra...</p>
            </div><?php
            header('Refresh:5;URL=index.php');
        } ?>
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
<?php
    function which_month($release_month){
        $month="";
        switch ($release_month){
            case "01": $month="január"; break;
            case "02": $month="február"; break;
            case "03": $month="március"; break;
            case "04": $month="április"; break;
            case "05": $month="május"; break;
            case "06": $month="június"; break;
            case "07": $month="július"; break;
            case "08": $month="augusztus"; break;
            case "09": $month="szeptember"; break;
            case "10": $month="október"; break;
            case "11": $month="november"; break;
            case "12": $month="december"; break;
      }
        return $month;
  }
?>