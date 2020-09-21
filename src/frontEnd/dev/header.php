<html>
    <head>
        <link rel="stylesheet" id="style">
    </head>
    <body>
    <div class="navbar-me">
        <div class="nav-content">
            <a class="nav-a" id="home">Home</a>
            <a class="nav-a" id="visits">Visitors</a>
            <a class="nav-a" id="iplog">Log</a>
            <a class="nav-a" id="cloud">Cloud</a>
            <a class="nav-a" id="ipcam">IP Cam</a>
            <a class="nav-a" id="userma">User Manager</a>

            <a id="logout"><button class="logout btn btn-outline-danger">Logout</button></a>
            <code class="logDat">Logged in as: <?php echo $_SESSION["user"] ?></code>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Menu ↓</button>

            <a id="logoutDrop" class="unused"><button class="logout btn btn-outline-danger">Logout</button></a>
            <code class="logDat">Logged in as: <?php echo $_SESSION["user"] ?></code>

            <div class="dropdown-content">
                <a class="nav-a" id="homeDrop">Home</a>
                <a class="nav-a" id="visitsDrop">Visitors</a>
                <a class="nav-a" id="iplogDrop">Log</a>
                <a class="nav-a" id="cloudDrop">Cloud</a>
                <a class="nav-a" id="ipcamDrop">IP Cam</a>
                <a class="nav-a" id="usermaDrop">User Manager</a>
            </div>
        </div>
    </div>

    </body>
    <script>
        var path = window.location.href.split('/');
        path.splice(path.indexOf('dev') + 1, path.length + 1 - path.indexOf('dev'));
        path = path.join("/");

        document.getElementById('style').href = `${path}/styleHeader.css`;

        document.getElementById('logout').href = `${path}/login.php?action=logout`;
        document.getElementById('logoutDrop').href = `${path}/login.php?action=logout`;

        document.getElementById('home').href = `${path}/index.php`;
        document.getElementById('homeDrop').href = `${path}/index.php`;
        document.getElementById('visits').href = `${path}/userInfo/index.php`;
        document.getElementById('visitsDrop').href = `${path}/userInfo/index.php`;
        document.getElementById('iplog').href = `${path}/ipLog/index.php`;
        document.getElementById('iplogDrop').href = `${path}/ipLog/index.php`;
        document.getElementById('cloud').href = `${path}/cloud/index.php`;
        document.getElementById('cloudDrop').href = `${path}/cloud/index.php`;
        document.getElementById('ipcam').href = `${path}/ipCam/index.php`;
        document.getElementById('ipcamDrop').href = `${path}/ipCam/index.php`;
        document.getElementById('userma').href = `${path}/userManagement/index.php`;
        document.getElementById('usermaDrop').href = `${path}/userManagement/index.php`;
    </script>
</html>