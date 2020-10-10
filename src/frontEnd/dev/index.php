
<?php 
session_start();
include '../config.php';

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
        <?php include './header.php'; ?>

        <b><h1 class="head-txt">Welcome <?php echo $_SESSION["user"] ?>!</h1></b>
    </body>
</html>