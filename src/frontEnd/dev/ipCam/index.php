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
        <title>IP Camera</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
    </head>
    <body>
        <?php include '../header.php'; ?>

        <h1 class="head-txt">IP Camera</h1>

        <form action="" method="post">
            <input class="reloadBtn" type="submit" name="someAction" value="Relaod" />
        </form>
        <div class="content">
            <img id="img" class="img">
        </div>
    </body>
</html>

<script>
    function loadImage(){
        document.getElementById("img").src = './save.jpg';
    }
</script>
<?php
    getImage();

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['someAction']))
    {
        getImage();
    }

    function getImage(){
        $url = "http://192.168.178.25:8080/shot.jpg";

        file_put_contents("save.jpg", file_get_contents($url));
        echo '<script> loadImage(); </script>';
    }
?>