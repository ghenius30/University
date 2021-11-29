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
            <?php if (isset($_SESSION["user"])) { /* ha már be van jelentkezve a user… */ ?>
                <form action="logout.php" method="POST">
                    <button id="logout_button" type="submit" title="Kijelentkezés">Kijelentkezés</button>
                </form>
                <?php echo "<p id='username_label'>Bejelentkezve mint <br><a>" . $_SESSION["user"] . "</a></p>";
            }?>
        </div>
    </nav>
</header>

<main>
    <?php if (isset($_SESSION["user"]) && $_SESSION["admin"]) { ?>
    <div class="addMovies-container">
            <form action="addMoviesForm.php" class="addMovies-form" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Új film vagy sorozat felvétele</legend>

                    <div class="media_type_container">
                        <input type="radio" id="movies" name="media_type" value="movies" required/>
                        <label for="movies">Film</label>

                        <input type="radio" id="series" name="media_type" value="series" required/>
                        <label for="series">Sorozat</label><br/>
                    </div>

                    <div class="picture_src_container">
                        <label for="picURL">Kép URL</label><br/>
                        <input type="url" id="picURL" name="picURL" size="30" placeholder="https://"/><br/>

                        <p>VAGY</p><br/>

                        <label for="picSRC">Kép forrás</label><br/>
                        <input type="hidden" name="MAX_FILE_SIZE" value="4000000"/>
                        <input type="file" id="picSRC" name="picSRC" accept="image/jpeg,image/png"/><br/>
                    </div>

                    <label for="title">Cím</label><br/>
                    <input type="text" id="title" name="title" size="30"/><br/>

                    <label for="trailerURL">Előzetes URL</label><br/>
                    <input type="url" id="trailerURL" name="trailerURL" size="30" placeholder="https://"/><br/>

                    <label for="director">Rendező</label><br/>
                    <input type="text" id="director" name="director" size="30"/><br/>

                    <label for="producer">Producer</label><br/>
                    <input type="text" id="producer" name="producer" size="30"/><br/>

                    <label for="genre">Műfaj</label><br/>
                    <input type="text" id="genre" name="genre" size="30" placeholder="felsorolás, vesszővel elválasztva"/><br/>

                    <label for="story">Forgatókönyvíró</label><br/>
                    <input type="text" id="story" name="story" size="30"/><br/>

                    <label for="actors">Főszerepben</label><br/>
                    <input type="text" id="actors" name="actors" size="30" placeholder="felsorolás, vesszővel elválasztva"/><br/>

                    <label for="release">Megjelenés dátuma</label><br/>
                    <input type="date" id="release" name="release" /><br/>

                    <button id="save-button" type="submit" name="save-button">Mentés</button>

                </fieldset>
            </form>
    </div>
        <?php } else { ?>
            <div class="errormessage">
                <span>Sajnáljuk, ez az oldal csak Admin jogosultságú felhasználóknak érhetők el! <br/>
                Ha még nincs felhasználói fiókod regisztrálj vagy jelentkezz be!</span>
                <p class="nextpage-message">Hamarosan átirányítunk a főoldalra...</p>
            </div>
        <?php
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