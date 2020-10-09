<html>
    <head>
        <link rel="stylesheet" id="style">
    </head>
    <body>
    <div class="navbar-me" id="navbar-me">
        <div class="nav-con">
            <div class="nav-elementGroup">
                <a class="nav-el" id="home">Home</a>
                <a class="nav-el" id="orga">Organizer</a>
                <a class="nav-el" id="set">Settings</a>
            </div>
            <div class="nav-control">
                <code class="logDat">Logged in as: <?php if(isset($_SESSION["user"])){ echo ($_SESSION["user"]); }else{ echo "--none--";} ?></code>
                <a id="logout"><button class="logout btn btn-outline-danger">Logout</button></a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Menu ↓</button>

            <div class="nav-control">
                <code class="logDat">Logged in as: <?php if(isset($_SESSION["user"])){ echo ($_SESSION["user"]); }else{ echo "--none--";} ?></code>
                <a id="logoutDrop"><button class="logout btn btn-outline-danger">Logout</button></a>
            </div>
            <div class="dropdown-content">
                <a class="nav-el" id="homeDrop">Home</a>
                <a class="nav-el" id="orgaDrop">Organizer</a>
                <a class="nav-el" id="setDrop">Settings</a>
            </div>
        </div>
    </div>
    </body>

    <script>
        var path = window.location.href.split('/');
        path.splice(path.indexOf('userPortal') + 1, path.length + 1 - path.indexOf('userPortal'));
        path = path.join("/");

        document.getElementById('style').href = `${path}/styleHeader.css`;

        document.getElementById('logout').href = `${path}/login.php?action=logout`;
        document.getElementById('logoutDrop').href = `${path}/login.php?action=logout`;

        document.getElementById('home').href = `${path}/index.php`;
        document.getElementById('homeDrop').href = `${path}/index.php`;
        document.getElementById('orga').href = `${path}/organizer/index.php`;
        document.getElementById('orgaDrop').href = `${path}/organizer/index.php`;
        document.getElementById('set').href = `${path}/settings/index.php#profile`;
        document.getElementById('setDrop').href = `${path}/settings/index.php#profile`;
    </script>
</html>