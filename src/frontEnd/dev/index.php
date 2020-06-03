
<?php 
session_start();
include './config.php';

if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ./login.php");
    die;
}
?>

<html>
    <head>
        <title>Developer Dashboard</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">

    </head>
    <body>
        <a href="./login.php?action=logout"><button class="logout btn btn-outline-danger">Log Out!</button></a>
        <h1>Welcome!</h1>
        <a href="./cloud/index.php"><button>Cloud</button></a>
    </body>
</html>