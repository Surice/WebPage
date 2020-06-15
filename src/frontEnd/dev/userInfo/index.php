<?php 
session_start();
include '../../config.php';
$file = 'cache.txt';

if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
    header( "Location: ../login.php");
    die;
}
?>

<html>
    <head>
    
        <title>Visitor Index</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
    </head>
    <body>
        <ul class="navbar-me">
            <li class="li"><a class="nav-a" href="../index.php">Home</a></li>
            <li class="li"><a class="nav-a" href="./index.php">Visitors</a></li>
            <li class="li"><a class="nav-a" href="../ipLog/index.php">Log</a></li>
            <li class="li"><a class="nav-a" href="../cloud/index.php">Cloud</a></li>
            <li class="li"><a class="nav-a" href="">None</a></li>
            <li class="li"><a href="../index.php"><button class="logout btn btn-outline-danger">Back</button></a></li>
            <li class="li"><code class="logDat">Logged in as: <?php echo $_SESSION["user"] ?></code></li>
        </ul>

        <h1 class="head-txt">The recent Visitors of the Website</h1>
       
        <table class="table" id="table">
            <tr class="table-head">
                <th><strong>At</strong></th>
                <th><strong>City</strong></th>
                <th><strong>state</strong></th>
                <th><strong>Country</strong></th>
                <th><strong>coordinates</strong></th>
                <th><strong>Provider</strong></th>
                <th><strong>postcode</strong></th>
                <th><strong>Time Zone</strong></th>
            </tr>
        </table>
    </body>

    <script>
        function createTable(data, dat, count){
            for (var e in data) {
                    var output = `<tr><th>${dat[count]}</th>`;

                    data[e].forEach(function(i){
                        output += `<th>${i}</th>`;
                    });

                    output += "</tr>";
                    document.getElementById('table').innerHTML += output;                    
                    count--;
            }
        }
        function req(){
                var data = <?php echo file_get_contents($file); ?>,
                    dat = Object.keys(data),
                    count = dat.length -1;

                createTable(data, dat, count);
        }  
    </script>
    <?php
            
            //the get request to backend
//            $getUrl = "192.168.178.38:999/getUser";
            $getUrl = "192.168.178.27:999/getUser";

            $ch = curl_init($getUrl);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
            curl_close($ch);


            file_put_contents($file, $response);
            echo '<script type="text/javascript">','req();','</script>';
;
        ?>
</html>