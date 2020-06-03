<?php 
session_start();
include '../../config.php';

if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ../login.php");
    die;
}
?>

<html>
    <head>
        <title>Visitor Index</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">

    </head>
    <body>
        <a href="../index.php"><button class="logout btn btn-outline-danger">Back</button></a>
        <h1>Welcome!</h1>
       
    </body>
</html>