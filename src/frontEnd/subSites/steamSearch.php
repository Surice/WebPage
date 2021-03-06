<html>
    <?php
        session_start();
    ?>
    <script>
        var xml = new XMLHttpRequest();
        xml.open("GET", "https://sebastian-web.de/api/v1/steamG");
        xml.send();
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                var content = JSON.parse(xml.responseText);

                for (e in content){
                    document.getElementById('lastScan').innerHTML += e.toString();
                    content = content[e];
                }
                content.forEach(e=>{
                    document.getElementById('table-me').innerHTML +=
                        `
                            <tr class="table-body">
                                <th class="tableE">${e[0]}</th>
                                <th class="tableE">
                                    <a target="_blank" class="link" href="${e[1]}")>${e[1]}</a>
                                </th>
                            </tr>
                        `;
                });
            }
        }
    </script>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale = 1">
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href='./steamSearchS.css'>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title>Steam-Games</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/Surice_logo_ti.ico">
    </head>
    <body>
        <ul class="navbar-me">
            <li>
                <a href="../index.php"><button class="exit btn btn-outline-danger">Back</button></a>
            </li>
        </ul>

        <code id="lastScan" class="lastScan">Last Scan: </code>
        <div class="siteContent">
            <h1 class="head-txt">current free games on Steam</h1>

            <table class="table-me" id="table-me">
                <tr class="table-head">
                    <th class="tableE"><strong>Name</strong></th>
                    <th class="tableE"><strong>Link</strong></th>
                </tr>
            </table>
        </div>
    </body>
</html>