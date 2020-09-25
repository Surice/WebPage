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
        <title>Visitor Index</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/pb.ico">
        <link rel="stylesheet" href="./style.css">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
    </head>
    <body>
        <?php include '../header.php'; ?>

        <h1 class="head-txt">User Management</h1>

        <div class="table-d">
            <table role="table" class="table" id="table">
                <thead role="rowgroup">
                    <tr role="row" class="table-head">
                        <th role="columnheader"><strong>Index</strong></th>
                        <th role="columnheader"><strong>E-Mail</strong></th>
                        <th role="columnheader"><strong>Firstname</strong></th>
                        <th role="columnheader"><strong>Lastname</strong></th>
                        <th role="columnheader"><strong>Password</strong></th>
                        <th role="columnheader"><strong>Control</strong></th>
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
            xml.open('GET', 'https://sebastian-web.de/api/v1/getUserAccount');
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
                var createRow = `
                    <tr role="row">
                        <td role="cell">${data[e].id}</td>
                        <td role="cell">${data[e].email}</td>
                        <td role="cell">${data[e].firstname}</td>
                        <td role="cell">${data[e].lastname}</td>
                        <td role="cell">${data[e].password}</td>
                        <td role="cell"><button class="btnDel" oncklick="delAcc(${data[e].id})">X</button></td>
                    </tr>
                `

                document.getElementById('table-bdy').innerHTML = createRow + document.getElementById('table-bdy').innerHTML;
            }
        }

        function delAcc(userId){
            console.log(userId);

            xml = new XMLHttpRequest();
            xml.open('POST', 'https://sebastian-web.de/api/v1/deleteUserAccounts');
            xml.setRequestHeader('authorization', token);
            xml.setRequestHeader("Content-Type", "application/json");
            xml.send({"id": userId});
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    var data = JSON.parse(xml.responseText);
                    console.log(data);

                }else if(xml.readyState == 4){
                    console.log(xml.status);
                }
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