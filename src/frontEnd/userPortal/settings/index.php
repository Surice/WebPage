<?php
    session_set_cookie_params(86400 * 30,"/");
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
                $userData = array('password' => password_hash($newPswrd, PASSWORD_DEFAULT), 'userId' => $userJson->id);

                $stmt = $db->prepare('UPDATE `user_accounts` SET `password`=:password WHERE id=:userId');
                $updatedUser = $stmt->execute($userData);
            }else{
    //            echo "rep wrong";
            }
        }else{
    //        echo "password wrong";
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
    function verifyDelete($email){
        $token = $_COOKIE['token'];     
        $pass = $_COOKIE['pass'];

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

        if(password_verify($pass, $userJson->password)){
            $userData = array('userId' => $userJson->id);
            print_r($userData['userId']);
/*
            $stmt = $db->prepare('DELETE FROM user_accounts WHERE id=:userId');
            $deletedUser = $stmt->execute($userData);
*/
//            header( "Location: ../login.php");
        }else{
            print_r('ERROR');
        }
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
                        <label class="inpLabel" for="mail">E-Mail:</label>
                        <br>
                        <input class="inpText" type="text" name="mail" id="mail" placeholder="E-Mail...">
                    </div>
                    <div class="valueDiv">
                        <label class="inpLabel" for="firstN">Firstname:</label>
                        <br>
                        <input class="inpText" type="text" name="firstN" id="firstN" placeholder="Firstname...">
                    </div>
                    <div class="valueDiv">
                        <label class="inpLabel" for="lastN">Lastname:</label>
                        <br>
                        <input class="inpText" type="text" name="lastN" id="lastN" placeholder="Lastname...">
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
                            <label class="inpLabel" for="cPswrd">Current Password:</label>
                            <br>
                            <input class="inpText" type="password" name="cPswrd" id="cPswrd" placeholder="Current Password...">
                        </div>
                        <div class="nPswrdDiv">
                            <div class="valueDiv">
                                <label class="inpLabel" for="nPswrd">New Password:</label>
                                <br>
                                <input class="inpText" type="password" name="nPswrd" id="nPswrd" placeholder="New Password...">
                            </div>
                            <div class="valueDiv">
                                <label class="inpLabel" for="rNPwswrd">Repeat New Password:</label>
                                <br>
                                <input class="inpText" type="password" name="rNPwswrd" id="rNPwswrd" placeholder="Repeat Password...">
                            </div>
                        </div>
                    </div>
                    <button class="btn-submit" type="submit">Change Password</button>
                </form>
            </div>
        </div>
        <div class="screen" id="orgaSet">
            <h1 class="head-txt">Organizer Settings</h1>
            <div class="content">
                <div class="tables">
                    <div class="headline-div">
                        <label class="headline">List-Manager</label>
                        <button class="btn-newList" onclick="newList()">Add New List</button>
                    </div>
                        <div class="lists-div">
                        <ul class="lists" id="lists"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="screen" id="delAcc">
            <h1 class="head-txt">Delete Account</h1>
            <div class="content">
                <div class="tables">
                    <div class="valueDiv">
                        <label class="inpLabel" for="email">Confirm with E-Mail:</label>
                        <br>
                        <input class="inpText" type="text" name="DelEmail" id="DelEmail" placeholder="E-Mail...">
                    </div>
                    <div class="valueDiv">
                        <label class="inpLabel" for="pswrd">Confirm with Password:</label>
                        <br>
                        <input class="inpText" type="password" name="delPswrd" id="delPswrd" placeholder="Password...">
                    </div>
                </div>
                <button onclick="delAccount()" class="btn-submit" type="submit">Delete Account permanently</button>
            </div>
        </div>
    </body>

    <script>
        window.onload = function () {
            window.scrollTo({top: 0,});

            getProfileValues();
            getAllLists();

            alt = window.location.hash.slice(1, window.location.hash.length);
            document.getElementById(alt).style.display = 'block';
        }

        window.addEventListener('hashchange', function(){
            if(alt) document.getElementById(alt).style.display = 'none';

            alt = window.location.hash.slice(1, window.location.hash.length);
            document.getElementById(alt).style.display = 'block';
        });

        function delAccount(){
            if(confirm("are you sure you want to delete your account permanently?")){

                const cookieContent = document.getElementById('delPswrd').value;
                const email = document.getElementById('DelEmail').value;

                var date = new Date();
                date.setTime(date.getTime()+(15*1000));
                document.cookie = `pass=${cookieContent}; expires=${date.toString()};`;

                var phpCode = "<?php $param1 = '"+email+"'; verifyDelete($param1); ?>";

                alert( phpCode );
            }   
        }
    </script>
</html>