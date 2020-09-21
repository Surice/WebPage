<?php
session_start();
include '../config.php';
include '../database.php';

$role = "Developer";

if(!empty($_POST) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['recaptchaResponse'])){

/* START Recaptcha request */
    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = $scretToken; //secret Key from Google reCaptcha
    $recaptcha_response = $_POST['recaptchaResponse'];
    $response = "";
    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
/* END Recaptcha request */

    echo $recaptcha->score;

    $stmt = $db->prepare('SELECT * FROM dev_user WHERE email = ?');
    $stmt -> execute(array($_POST["email"]));

    $user = $stmt->fetch();
//    print_r(password_hash($_POST["password"], PASSWORD_DEFAULT));


    //TRUE if email and password is correct
    if(password_verify($_POST["password"], $user['password']) && $recaptcha->score >= 0.8){
        $_SESSION["loggedIn"] = true;
        $_SESSION["user"] = $user['username'];

        $payloadData = array('username' => $user['username'], 'role' => $role);

        $payload = json_encode($payloadData);

        $ch = curl_init('192.168.178.31:8082/api/v1/getToken');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        
      $result = curl_exec($ch);

        if($result == false && !isset($result)){
            die("Curl failed: " . curL_error($ch));
        }
        curl_close($ch);

        $out = json_decode($result, true);
        setcookie("token", $out['token']);


        header("Location: ./index.php");
    }else{
        if($_POST["password"] != $password || $_POST["email"] != $email){
            $response = "email or Password was wrong";
        }else if($recaptcha->score >= 0.8){
            $response =  "you are not authorized because you seem like a bot";
        }else{
            $response =  "login Failed";
        }
    }
}else{
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

    <div class="container-lg h-100 center-div">
        <div class="row justify-content-center align-items-center h-100">
            <div class="card" style="width: 18rem;">
                <div class="card-header align-items-center">Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="text" name="email" class="form-control">
                            <br>
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control">
                            <br>
                            <button type="submit" class="btn btn-primary mb-3">Submit!</button>
                            <?php
                                if(!empty($response)){
                            ?>
                            <div class="row">
                                <div class="alert alert-danger p-1" style="display: inline-block; margin-top: 8px;" role="alert"><?php echo $response ?></div>
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