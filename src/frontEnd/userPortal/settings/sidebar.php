<html>
    <head>
        <link rel="stylesheet" href="./styleSidebar.css">
    </head>
    <body>
        <div id="sideDiv" class="sidebar">
            <a class="values active" href="#profile">Profile Informations</a>
            <a class="values" href="#pswrd">Change Password</a>
            <a class="values" href="#delAcc">Delete Account</a>
        </div>
    </body>

    <script>
        window.location.hash = '#profile';

        window.addEventListener('hashchange', function(){
            const alt = document.getElementsByClassName('active')[0];
            alt.className = alt.className.replace('active', ' ');

            const all = document.getElementsByClassName('values');

            for (var i = 0; i < all.length; i++) {
                if(all[i].hash == window.location.hash){
                    all[i].className = all[i].className +' active';
                }
            }
        })
    </script>
</html>