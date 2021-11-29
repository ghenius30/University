<?php
    session_start(); // session betöltése
    session_unset(); // session változók kiürítése
    session_destroy(); // session megszüntetése
    header("Location: index.php");
?>