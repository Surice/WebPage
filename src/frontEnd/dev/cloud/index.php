<?php 
session_start();
include '../../config.php';
$file = 'cache.txt';

if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ../login.php");
    die;
}
?>
<html>
    <head>
    
        <title>Visitor Index</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
    </head>
    <body>
        <ul class="navbar-me">
            <li class="li"><a class="nav-a" href="../index.php">Home</a></li>
            <li class="li"><a class="nav-a" href="./index.php">Visitors</a></li>
            <li class="li"><a class="nav-a" href="../ipLog/index.php">Log</a></li>
            <li class="li"><a class="nav-a" href="./index.php">Cloud</a></li>
            <li class="li"><a class="nav-a" href="">None</a></li>
            <li class="li"><a href="../index.php"><button class="logout btn btn-outline-danger">Back</button></a></li>
            <li class="li"><code class="logDat">Logged in as: <?php echo $_SESSION["user"] ?></code></li>
        </ul>

        <h1 class="head-txt">Cloud Service</h1>
    </body>
</html>