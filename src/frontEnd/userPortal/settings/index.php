<?php 
session_start();
include '../../config.php';
/*
if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ../login.php");
    die;
}
*/
?>

<html>
    <head>
        <title>User Portal Settings</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
    </head>
    <body>
        <?php include '../header.php'; ?>
        <?php include './sidebar.php'; ?>

        <div class="screen" id="profile">
            <h1 class="head-txt">Profile Informations</h1>
            <div class="content">
                <div class="profInfoTable">
                    <div>
                        <label for="mail">E-Mail:</label>
                        <input >
                    </div>
                </div>
            </div>
        </div>
        <div class="screen" id="pswrd">
            <h1 class="head-txt">Change Password</h1>
        </div>
        <div class="screen" id="delAcc">
            <h1 class="head-txt">Delete Account</h1>
        </div>
    </body>

    <script>
        var alt = undefined;
        document.getElementById(window.location.hash.slice(1, window.location.hash.length)).style.display = 'block';

        window.addEventListener('hashchange', function(){
            if(alt){
                document.getElementById(alt).style.display = 'none';
            }

            document.getElementById(window.location.hash.slice(1, window.location.hash.length)).style.display = 'block';
            alt = window.location.hash.slice(1, window.location.hash.length);
        });
    </script>
</html>