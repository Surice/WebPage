<?php 
session_start();
include '../../config.php';
include '../../database.php';

if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ../login.php");
    die;
}

if(!empty($_POST) && !empty($_POST['cPswrd']) && !empty($_POST['nPswrd']) && !empty($_POST['rNPwswrd'])){
    $oldPswrd = $_POST['cPswrd'];
    $newPswrd = $_POST['nPswrd'];
    $repPswrd = $_POST['rNPwswrd'];
    $token = $_COOKIE['token'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://sebastian-web.de/api/v1/getUserAccount",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_HTTPHEADER => array("authorization: $token"),
    ));
    $user = curl_exec($curl);
    $userJson = json_decode($user)[0];
    curl_close($curl);

    if(password_verify($oldPswrd, $userJson->password)){
        if($newPswrd == $repPswrd){
            echo "success";
            $userData = array('password' => password_hash($newPswrd, PASSWORD_DEFAULT), 'userId' => $userJson->id);

            $stmt = $db->prepare('UPDATE `user_accounts` SET `password`=:password WHERE id=:userId');
            $updatedUser = $stmt->execute($userData);
        }else{
//            echo "rep wrong";
        }
    }else{
//        echo "password wrong";
    }
}
else if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['pswrd'])){
    $email = $_POST['email'];
    $pswrd = $_POST['pswrd'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://sebastian-web.de/api/v1/getUserAccount",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_HTTPHEADER => array("authorization: $token"),
    ));
    $user = curl_exec($curl);
    $userJson = json_decode($user)[0];
    curl_close($curl);

    if(password_verify($Pswrd, $userJson->password)){
        $userData = array('userId' => $userJson->id);

        $stmt = $db->prepare('DELETE FROM `user_accounts` WHERE `id` = :userId');
        $deletedUser = $stmt->execute($userData);
    }
}else{
//    echo "cannot get data";

/*
     if(!empty($_POST)){
         if (empty($_POST['email']) && empty($_POST['password'])){
             $response = "email and Password must be set";
         }else if(empty($_POST['email'])){
             $response = "email must be set";
         }else if(empty($_POST['password'])){
             $response = "Password must be set";
         }else{
             $response = "unknown error";
         }
     }
*/
 }

?>

<html>
    <head>
        <title>User Portal Settings</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/Surice_logo_ti.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
        <script src="./index.js"></script>
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
                        <input type="text" name="mail" id="mail">
                    </div>
                    <div class="valueDiv">
                        <label for="firstN">Firstname:</label>
                        <br>
                        <input type="text" name="firstN" id="firstN">
                    </div>
                    <div class="valueDiv">
                        <label for="lastN">Lastname:</label>
                        <br>
                        <input type="text" name="lastN" id="lastN">
                    </div>
                </div>
                <button class="btn-submit" onclick="saveSettings()">Change Settings</button>
            </div>
        </div>
        <div class="screen" id="pswrd">
            <h1 class="head-txt">Change Password</h1>
            <div class="content">
                <form method="post" action="index.php#pswrd" class="content-form">
                    <div class="tables">
                        <div class="valueDiv">
                            <label for="cPswrd">Current Password:</label>
                            <br>
                            <input type="password" name="cPswrd" id="cPswrd">
                        </div>
                        <div class="nPswrdDiv">
                            <div class="valueDiv">
                                <label for="nPswrd">New Password:</label>
                                <br>
                                <input type="password" name="nPswrd" id="nPswrd">
                            </div>
                            <div class="valueDiv">
                                <label for="rNPwswrd">Repeat New Password:</label>
                                <br>
                                <input type="password" name="rNPwswrd" id="rNPwswrd">
                            </div>
                        </div>
                    </div>
                    <button class="btn-submit" type="submit">Change Password</button>
                </form>
            </div>
        </div>
        <div class="screen" id="delAcc">
            <h1 class="head-txt">Delete Account</h1>
            <div class="content">
                <form method="post" action="../login.php?action=logout" class="content-form">
                    <div class="tables">
                        <div class="valueDiv">
                            <label for="email">Confirm with E-Mail:</label>
                            <br>
                            <input type="text" name="email" id="email">
                        </div>
                        <div class="valueDiv">
                            <label for="pswrd">Confirm with Password:</label>
                            <br>
                            <input type="password" name="pswrd" id="pswrd">
                        </div>
                    </div>
                    <button class="btn-submit" type="submit">Delete Account permanently</button>
                </form>
            </div>
        </div>
    </body>

    <script>
        getValues();

        alt = window.location.hash.slice(1, window.location.hash.length);

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