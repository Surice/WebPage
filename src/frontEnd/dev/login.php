<?php
session_start();
include '../config.php';
$username = $confuser;
$password = $confpw;

if(!empty($_POST) && !empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['recaptchaResponse'])){
    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = $scretToken; //secret Key from Google reCaptcha
    $recaptcha_response = $_POST['recaptchaResponse'];
    $response = "";

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    echo $recaptcha->score;
    if($_POST["password"] == $password && $recaptcha->score >= 0.8 && $_POST["username"] == $username){
        $_SESSION["loggedIn"] = true;
        $_SESSION["user"] = $_POST["username"];

#put request here lol
        $data = array('username' => $_POST['username']);

        $payload = json_encode($data);

        $ch = curl_init('https://sebastian-web.de/api/v1/users');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        
        $result = curl_exec($ch);

        if($result == false){
            die("Curl failed: " . curL_error($ch));
        }
        curl_close($ch);
        $out = json_decode($result, true);
        setcookie("token", $out['token']);


        header("Location: ./index.php");
    }else{
        if($_POST["password"] != $password || $_POST["username"] != $username){
            $response = "Username or Password was wrong";
        }else if($recaptcha->score >= 0.8){
            $response =  "you are not authorized because you seem like a bot";
        }else{
            $response =  "login Failed";
        }
    }
}else{
    if(!empty($_POST)){
        if (empty($_POST['username']) && empty($_POST['password'])){
            $response = "Username and Password must be set";
        }else if(empty($_POST['username'])){
            $response = "Username must be set";
        }else if(empty($_POST['password'])){
            $response = "Password must be set";
        }else{
            $response = "unknown error";
        }
    }
}


if (!empty($_GET) && $_GET['action'] == "logout") {
    try {
        session_destroy();
        header("Location: ./login.php");
    } catch (exception $err) {
        echo 'loggout Faild ($err)';
    }
}
?>

<html>

<head>
    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/pb.ico">
    <link rel="stylesheet" href="./styleLogin.css">
    <meta name="viewport" content="width=device-width, initial-scale = 1">

    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $siteKey ?>"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo $siteKey ?>', {
                action: 'submit'
            }).then(function(token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
</head>

<body>
    <ul class="navbar-me">
        <li>
            <a href="../index.php"><button class="exit btn btn-outline-danger">Back</button></a>
        </li>
    </ul>

    <!-- Cookie Consent by https://www.PrivacyPolicies.com -->
    <script type="text/javascript" src="//www.privacypolicies.com/public/cookie-consent/3.1.0/cookie-consent.js"></script>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    cookieconsent.run({"notice_banner_type":"interstitial","consent_type":"express","palette":"light","language":"en","website_name":"sebastian-web.de","cookies_policy_url":"https://sebastian-web.de#impressum","change_preferences_selector":""});
    });
    </script>

    <noscript>Cookie Consent by <a href="https://www.PrivacyPolicies.com/cookie-consent/" rel="nofollow">PrivacyPolicies.com</a></noscript>
    <!-- End Cookie Consent -->

    <div class="container-lg h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="card" style="width: 18rem;">
                <div class="card-header align-items-center">Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" type="text" name="username" class="form-control">
                            <br>
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control">
                            <br>
                            <button type="submit" class="btn btn-primary mb-3">Submit!</button>
                            <?php
                                if(!empty($response)){
                            ?>
                            <div class="row">
                                <div class="alert alert-danger p-1" style="display: inline-block" role="alert"><?php echo $response ?></div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>

                        <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>