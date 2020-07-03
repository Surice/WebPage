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
    
        <title>Visitor Index</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
    </head>
    <body>
        <ul class="navbar-me">
            <li><a class="nav-a" href="../index.php">Home</a></li>
            <li><a class="nav-a" href="./index.php">Visitors</a></li>
            <li><a class="nav-a" href="../ipLog/index.php">Log</a></li>
            <li><a class="nav-a" href="../cloud/index.php">Cloud</a></li>
            <li><a class="nav-a" href="">None</a></li>

            <li><a class="logout" href="../index.php"><button class="btn btn-outline-danger">Back</button></a></li>
            <li><code class="logDat">Logged in as: <?php echo $_SESSION["user"] ?></code></li>
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
            <tbody id="table-bdy">

            </tbody>
        </table>
    </body>

    <script>
        myf();
        async function myf(){
            var token = await getCo();

            xml = new XMLHttpRequest();
            xml.open('GET', 'https://sebastian-web.de/api/v1/getUsers');
            xml.setRequestHeader('authorization', token);
            xml.setRequestHeader("Content-Type", "application/json");
            xml.send();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    var data = JSON.parse(xml.responseText);

                    createTable(data);

                }else if(xml.readyState == 4){
                    console.log(xml.status);
                }
            }
        }

//old code

        function createTable(data){
            for (var e in data){
                var output = `<tr><th>${e}</th>`;

                data[e].forEach(function(i){
                    output += `<th>${i}</th>`;
                });

                output += "</tr>";
                document.getElementById('table-bdy').innerHTML = output + document.getElementById('table-bdy').innerHTML;
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
</html>