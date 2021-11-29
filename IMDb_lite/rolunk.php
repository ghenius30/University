<?php session_start();?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/imdb_lite_ico.png" type="image/png">
    <title>IMDb Lite: Rólunk</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <link rel="stylesheet" type="text/css" href="rolunk_style.css">
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
                        <li><a href="rolunk.php" class="current">Rólunk</a></li>
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
		<div class="rolunk">
		
			<article>
			<h1>KIK VAGYUNK MI?</h1>
			<p class="rolunk-text">Mi az IMDb Lite-nál nap, mint nap azon dolgozunk, hogy olyan online film és sorozat böngészési élményt nyújtsunk,
			   amellyel Te, kedves felhasználó, mindig gyorsan, kényelmesen megtalálod, amit szeretnél nézni otthon, illetve moziban!
			   Széleskörű leírásainkkal, keresési és értékelési lehetőségeinkkel számodra a lehető legjobb módon szolgáljuk ki igényeidet.</p>
			</article>
			
			<article>
			<h1>Információk</h1>
			<p>Email: IMDb_Lite@gmail.com</p>
			<p>Elérhetőség: +36301234567</p>	
			</article>
			
			
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