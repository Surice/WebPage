<html>
    <head>
        <link rel="stylesheet" id="style">
    </head>
    <body>
    <ul class="navbar-me">
        <li class="li"><a class="nav-a" id="home">Home</a></li>
        <li class="li"><a class="nav-a" id="visits">Visitors</a></li>
        <li class="li"><a class="nav-a" id="iplog">Log</a></li>
        <li class="li"><a class="nav-a" id="cloud">Cloud</a></li>
        <li class="li"><a class="nav-a" id="ipcam">IP Cam</a></li>
        <li class="li"><a class="nav-a" href="">None</a></li>
        <li class="li"><a href="./login.php?action=logout"><button class="logout btn btn-outline-danger">Logout</button></a></li>
        <li class="li"><code class="logDat">Logged in as: <?php echo $_SESSION["user"] ?></code></li>
    </ul>
    </body>
    <script>
        var path = window.location.href.split('/');
        path.splice(path.indexOf('dev') + 1, path.length + 1 - path.indexOf('dev'));
        path = path.join("/");

        document.getElementById('style').href = `${path}/styleHeader.css`;

        document.getElementById('home').href = `${path}/index.php`;
        document.getElementById('visits').href = `${path}/userInfo/index.php`;
        document.getElementById('iplog').href = `${path}/ipLog/index.php`;
        document.getElementById('cloud').href = `${path}/cloud/index.php`;
        document.getElementById('ipcam').href = `${path}/ipCam/index.php`;
    </script>
</html>