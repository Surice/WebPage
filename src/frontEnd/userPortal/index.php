<?php
session_set_cookie_params(86400 * 30,"/");
session_start();
include '../config.php';

if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ./login.php");
    die;
}
?>

<html>
    <head>
        <title>User Portal</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/Surice_logo_ti.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
    </head>
    <body>
        <?php include './header.php'; ?>

        <div class="content">
            <h1 class="head-txt">Welcome <?php echo $_SESSION["user"] ?>!</h1>
        </div>
    </body>
</html>