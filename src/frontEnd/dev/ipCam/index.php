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

        <button class="reloadBtn" onclick="getImage()">Reload</button>

        <div class="content">
            <img id="img" class="img">
        </div>
    </body>
</html>

<script>
    getImage();

    async function getImage(){
        const token = await getCo();

        document.getElementById('img').src = `https://sebastian-web.de/api/v1/getImg.jpg?authorization=${token}&t=${Date.now()}`;
    }

    function getCo(){
            var co = document.cookie.split(";"),
                out = "none";
            co.forEach(e=>{
                if(e.startsWith("token=")){
                    e = e.slice(6);
                    
                    out = e;
                }
            });
            return out;
        }
</script>