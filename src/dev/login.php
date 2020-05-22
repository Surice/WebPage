<?php
    session_start();
    include './config.php';
    $password = $confpw;

    if(!empty($_POST) && !empty($_POST['password']) && !empty($_POST['recaptchaResponse'])){
         // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = $scretToken; //secret Key from Google reCaptcha
    $recaptcha_response = $_POST['recaptchaResponse'];

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

        echo $recaptcha->score;
        if($_POST["password"] == $password && $recaptcha->score >= 0.8){
            $_SESSION["loggedIn"] = true;
            header("Location: ./index.php");
        }else{
            echo "login Failed";
        }
    }
    if(!empty($_GET) && $_GET['action'] == "logout"){
        try{
            session_destroy();
            echo "Sucessfully logged out!";
        }catch (exception $err){
            echo 'loggout Faild ($err)';
        }
    }
?>

<html>
    <head>
        <title>Login</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/pb.ico">

        <!--need to add the siteKey to the end of the src partwise manually added. should be at the config.php-->
        <script src="https://www.google.com/recaptcha/api.js?render=6LeQEfsUAAAAAM36CtF1fucgB7dwRWR1DmBnwjPh"></script> 
        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute('6LeQEfsUAAAAAM36CtF1fucgB7dwRWR1DmBnwjPh', { action: 'submit' }).then(function (token) {
                    var recaptchaResponse = document.getElementById('recaptchaResponse');
                    recaptchaResponse.value = token;
                });
            });
        </script>
    </head>
    <body>
        <h1>Login</h1>
        <form method="post">
            <label for="password">Passwort</label>
            <input id="password" type="password" name="password">
            <button type="submit">Submit!</button>
            <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
        </form>   
    </body>
</html>