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
                <div class="tables">
                    <div class="valueDiv">
                        <label for="mail">E-Mail:</label>
                        <br>
                        <input type="text" name="mail">
                    </div>
                    <div class="valueDiv">
                        <label for="firstN">Firstname:</label>
                        <br>
                        <input type="text" name="firstN">
                    </div>
                    <div class="valueDiv">
                        <label for="lastN">Lastname:</label>
                        <br>
                        <input type="text" name="lastN">
                    </div>
                </div>
                <button>Change Settings</button>
            </div>
        </div>
        <div class="screen" id="pswrd">
            <h1 class="head-txt">Change Password</h1>
            <div class="content">
                <div class="tables">
                    <div class="valueDiv">
                        <label for="cPswrd">Current Password:</label>
                        <br>
                        <input type="password" name="cPswrd">
                    </div>
                    <div class="nPswrdDiv">
                        <div class="valueDiv">
                            <label for="nPswrd">New Password:</label>
                            <br>
                            <input type="password" name="nPswrd">
                        </div>
                        <div class="valueDiv">
                            <label for="rNPwswrd">Repeat New Password:</label>
                            <br>
                            <input type="password" name="rNPwswrd">
                        </div>
                    </div>
                </div>
                <button>Change Password</button>
            </div>
        </div>
        <div class="screen" id="delAcc">
            <h1 class="head-txt">Delete Account</h1>
        </div>
    </body>

    <script>
        var alt = 'profile';
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