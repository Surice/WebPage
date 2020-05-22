
<?php 
session_start();

if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ./login.php");
    die;
}
?>

<html>
    <head>
        <title>Developer Dashboard</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/pb.ico">

    </head>
    <body>
        <a href="./login.php?action=logout"><button>Log Out!</button></a>
        <h1>Welcome!</h1>
    </body>
</html>