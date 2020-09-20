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
        <?php include '../header.php'; ?>

        <h1 class="head-txt">The recent Visitors of the Website</h1>
        <div class="table-d">
            <table role="table" class="table" id="table">
                <thead role="rowgroup">
                    <tr role="row" class="table-head">
                        <th role="columnheader"><strong>At</strong></th>
                        <th role="columnheader"><strong>City</strong></th>
                        <th role="columnheader"><strong>state</strong></th>
                        <th role="columnheader"><strong>Country</strong></th>
                        <th role="columnheader"><strong>coordinates</strong></th>
                        <th role="columnheader"><strong>Provider</strong></th>
                        <th role="columnheader"><strong>postcode</strong></th>
                        <th role="columnheader"><strong>Time Zone</strong></th>
                    </tr>
                </thead>
                <tbody role="rowgroup" id="table-bdy">

                </tbody>
            </table>
        </div>
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

        function createTable(data){
            for (var e in data){
                var output = `<tr role="row"><td role="cell">${e}</td>`;

                data[e].forEach(function(i){
                    output += `<td role="cell">${i}</td>`;
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