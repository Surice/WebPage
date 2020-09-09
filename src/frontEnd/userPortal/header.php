<html>
    <head>
        <link rel="stylesheet" id="style">
    </head>
    <body>
    <ul class="navbar-me">
        <li class="li"><a class="nav-a" id="home">Home</a></li>
        <li class="li"><a class="nav-a" href="">To-Do Liste</a></li>
        <li class="li"><a href="./login.php?action=logout"><button class="logout btn btn-outline-danger">Logout</button></a></li>
        <li class="li"><code class="logDat">Logged in as: <?php echo $_SESSION["user"] ?></code></li>
    </ul>
    </body>
    <script>
        var path = window.location.href.split('/');
        path.splice(path.indexOf('userPortal') + 1, path.length + 1 - path.indexOf('userPortal'));
        path = path.join("/");

        document.getElementById('style').href = `${path}/styleHeader.css`;

        document.getElementById('home').href = `${path}/index.php`;
    </script>
</html>