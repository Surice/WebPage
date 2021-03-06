<?php
session_set_cookie_params(86400 * 30,"/");
session_start();
include '../config.php';
include '../database.php';

$role = "user";

if(!empty($_POST) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['password']) && !empty($_POST['repPassword']) && !empty($_POST['email']) && !empty($_POST['recaptchaResponse'])){

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
//    print_r(password_hash($_POST["password"], PASSWORD_DEFAULT));

    if($_POST['password'] == $_POST['repPassword']){
        $stmt = $db->prepare('SELECT email FROM user_accounts WHERE email = ?');
        $stmt -> execute(array($_POST["email"]));

        $searchedUser = $stmt->fetch();


        //TRUE if email and password is correct
        if(!$searchedUser && $recaptcha->score >= 0.8){
            $userData = array('email' => $_POST["email"], 'password' => password_hash($_POST["password"], PASSWORD_DEFAULT), 'firstname' => $_POST["firstname"], 'lastname' => $_POST["lastname"]);

            $stmt = $db->prepare('INSERT INTO user_accounts (email, password, firstname, lastname) VALUES (:email, :password, :firstname, :lastname)');
            $createdUser = $stmt->execute($userData);



            if($createdUser){
                $_SESSION["loggedIn"] = true;
                $_SESSION["user"] = "{$_POST['firstname']} {$_POST['lastname']}";

                $payloadData = array('username' => $_POST['email'], 'role' => $role);

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

                $postData = json_encode(array('name' => 'ToDoList'));

                $curl = curl_init("https://sebastian-web.de/api/v1/createUserList?authorization={$out['token']}");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
                );

                curl_exec($curl);
                curl_close($curl);


                header("Location: ./index.php");
            }else{
                $response = "cannot register";
            }

        }else{
            if($user){
                $response = "email already registered";
            }else if($recaptcha->score >= 0.8){
                $response =  "you are not authorized because you seem like a bot";
            }else{
                $response =  "login Failed";
            }
        }
    }else{
        $response = "repeated password doesn´t fit";
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
    <title>Register User Portal</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/Surice_logo_ti.ico">
    <link rel="stylesheet" href="./styleRegister.css">
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
                <div class="subLabHead card-header align-items-center">
                    <a href="./login.php"><button class="btn-me btn btn-primary mb-3">Sign In</button></a>
                    <p>Register</p>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input id="firstname" type="text" name="firstname" class="form-control">
                            <br>
                            <label for="lastname">Lastname</label>
                            <input id="lastname" type="text" name="lastname" class="form-control">
                            <br>
                            <label for="email">Email</label>
                            <input id="email" type="text" name="email" class="form-control">
                            <br>
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control">
                            <br>
                            <label for="repPassword">repeat Password</label>
                            <input id="repPassword" type="password" name="repPassword" class="form-control">
                            <br>
                            <div class="subLab">
                                <button type="submit" class="btn-me btn btn-primary mb-3">Submit!</button>
                            </div>

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