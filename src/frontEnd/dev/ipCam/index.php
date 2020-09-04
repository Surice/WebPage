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

        <button class="reloadBtn" oncklick="getImage()">Reload</button>

        <div class="content">
            <img id="img" class="img">
        </div>
    </body>
</html>

<script>
    getImage();

    async function getImage(){
        var token = await getCo();

        xml = new XMLHttpRequest();
            xml.open('GET', 'http://192.168.178.27:8082/api/v1/getImg');
            xml.setRequestHeader('authorization', token);
            xml.setRequestHeader("Content-Type", "application/json");
            xml.send();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    console.log("success");
                }else{
                    console.log("some went wrong");
                }
            }
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