<html>
    <head>
        <link rel="stylesheet" href="./styleSidebar.css">
        <script src="https://kit.fontawesome.com/732a3ed8e9.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="sideDiv" class="sidebar">
            <a class="values" href="#profile">Profile Informations</a>
            <a class="values" href="#pswrd">Change Password</a>
            <a class="values" href="#orgaSet">Organizer Settings</a>
            <a class="values" href="#delAcc">Delete Account</a>
        </div>

        <div class="arrow">
            <button class="btnArrow" onclick="displaySidebar()"><i class="fas fa-angle-right SideArrow"></i></button>
        </div>
    </body>

    <script>
        var visible = false;

        setHighlighting();

        window.addEventListener('hashchange', function(){
            const alt = document.getElementsByClassName('active')[0];
            alt.className = alt.className.replace('active', ' ');

            setHighlighting();
        });

        document.addEventListener("click", function(){
            if(visible && window.innerWidth <= 1000){
                document.getElementById('sideDiv').style.display = "none";
                visible = false;
            }
        });

        function setHighlighting(){
            const all = document.getElementsByClassName('values');

            for (var i = 0; i < all.length; i++) {
                if(all[i].hash == window.location.hash){
                    all[i].className = all[i].className +' active';
                }
            }
        }

        function displaySidebar(){
            document.getElementById('sideDiv').style.display = "block";
            setTimeout(function(){ visible = true; }, 20);
        }
    </script>
</html>