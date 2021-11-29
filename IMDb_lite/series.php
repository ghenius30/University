<?php session_start();?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/imdb_lite_ico.png" type="image/png">
    <title>IMDb Lite: Sorozatok</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <link rel="stylesheet" type="text/css" href="movies_series_style.css">
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
                        <li><a href="series.php" class="current">Sorozatok</a></li>
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
    <aside>
        <div>
            <h3>Legújabb sorozatok</h3><?php
            $data=read_file();

            if (!(empty($data))) {
                foreach ($data as $datatype) {
                    if (array_keys($datatype)[0] === "series") {
                        foreach ($datatype as $actual) {
                            $ID = $actual["ID"];
                            $title = $actual["title"];
                            if (preg_match("/(201.)/", $title) || (preg_match("/(202.)/", $title))) {?>
                                <span><a href="#<?php echo $ID; ?>"><?php echo $title; ?></a><br/></span><?php
                            }
                        }
                    }
                }
            }?>
        </div>
        <div>
            <h3>Régebbi sorozatok</h3><?php

            if (!(empty($data))) {
                foreach ($data as $datatype) {
                    if (array_keys($datatype)[0] === "series") {
                        foreach ($datatype as $actual) {
                            $ID = $actual["ID"];
                            $title = $actual["title"];
                            if (!(preg_match("/(201.)/", $title)) && !(preg_match("/(202.)/", $title))) {?>
                                <span><a href="#<?php echo $ID; ?>"><?php echo $title; ?></a><br/></span><?php
                            }
                        }
                    }
                }
            }?>
        </div>
    </aside>

    <?php
        if (empty($data)) {?>
            <div class="message">
                <span>Sajnáljuk, egyelőre nincsenek sorozatok a kínálatban!</span>
                <p class="nextpage-message">Hamarosan visszairányítunk a főoldalra...</p>
            </div>
            <?php header('Refresh:5;URL=index.php');

        } else if (!(empty($data))) {?>
            <main><?php
                foreach ($data as $datatype) {
                    if (array_keys($datatype)[0] === "series") {
                        foreach ($datatype as $actual) {
                            $ID = $actual["ID"];
                            $title = $actual["title"];
                            if (empty($actual["picURL"])) {
                                $source = $actual["picSRC"];
                            } else if (empty($actual["picSRC"])){
                                $source = $actual["picURL"];
                            }
                            $trailerURL = $actual["trailerURL"];
                            $director = $actual["director"];
                            $producer = $actual["producer"];
                            $genre = $actual["genre"];
                            $story = $actual["story"];
                            $actors = $actual["actors"];
                            $release = $actual["release"]; ?>

                            <div class="series-container">
                                <div class="series">
                                    <a id="<?php echo $ID;?>" class="anchor">&nbsp;</a>
                                    <a href="<?php echo $trailerURL;?>"><img src="<?php echo $source;?>" title="<?php echo $title;?> előzetes" alt="<?php echo $title;?>" height="340" width="213"></a>
                                    <table>
                                        <caption><?php echo $title;?></caption>
                                        <tr>
                                            <th id="<?php echo $ID;?>-rendezo">Rendező:</th>
                                            <td headers="<?php echo $ID;?>-rendezo"><?php echo $director;?><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th id="<?php echo $ID;?>-producer">Producer:</th>
                                            <td headers="<?php echo $ID;?>-producer"><?php echo $producer;?></td>
                                        </tr>
                                        <tr>
                                            <th id="<?php echo $ID;?>-mufaj">Műfaj:</th>
                                            <td headers="<?php echo $ID;?>-mufaj">
                                                <?php echo $genre;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th id="<?php echo $ID;?>-forgatokony">Forgatókönyvíró:</th>
                                            <td headers="<?php echo $ID;?>-forgatokony">
                                                <?php echo $story;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th id="<?php echo $ID;?>-foszerep">Főszerepben:</th>
                                            <td headers="<?php echo $ID;?>-foszerep">
                                                <?php echo $actors;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th id="<?php echo $ID;?>-datum">Megjelenés dátuma:</th>
                                            <td headers="<?php echo $ID;?>-datum">
                                                <?php echo $release;?>
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="rating">
                                        <form method="post">
                                            <p><label for="<?php echo $ID;?>-rating">Értékelés:</label>
                                                <input type="range" id="<?php echo $ID;?>-rating" name="<?php echo $ID;?>-rating" min="1" max="5" value="3" class="slider">
                                                <INPUT type="submit" name="Küldés"></p>
                                            <p class="number">1 2 3 4 5</p>
                                        </form>
                                    </div>
                                </div>
                            </div><?php
                        }
                    }
                }?>
            </main><?php
        }?>

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
function read_file(){
    $data = [];
    $file = fopen("db/mediadata.txt", "r");
    $line = fgets($file);
    do{
        $data[] = unserialize($line);
    }while(($line = fgets($file)) !== false);

    fclose($file);
    return $data;
}