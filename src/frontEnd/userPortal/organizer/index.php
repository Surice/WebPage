<?php
    include '../../config.php';

    session_set_cookie_params(86400 * 30,"/");
    session_start();

    if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
        header( "Location: ../login.php");
        die;
    }
?>

<html>
    <head>
        <!-- FontAwesome Import -->
            <script src="https://kit.fontawesome.com/732a3ed8e9.js" crossorigin="anonymous"></script>
        <!-- End FontAwesome Import -->


        <meta name="viewport" content="width=device-width, initial-scale = 1">
        <meta charset="utf-8"/>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/Surice_logo_ti.ico">
        <link rel="stylesheet" href="style.css">
        <script src="./logic.js"></script>
    </head>
    <body>
        <?php include '../header.php'; ?>
        <div class="placeBar"></div>
        <div class="header-div">
            <label class= "Headline">Organizer</label>

            <div class="listChooser">
                <!-- <div class="vertBar"></div> -->
                <ul class= "nav-links" id="nav-links"></ul>
                <div class="select-wrapper">
                    <select class="nav-links-sel" id="nav-links-sel" onchange="changeList(true)"></select>
                </div>
                <!-- <div class="vertBar"></div> -->
            </div>

            <div class="btnControl">
                <!-- <button onclick="addNewList()" class="newListBtn">New List</button> -->
                <button onclick="addNewItem()" class="addItemBtn">New Item</button>
            </div>
        </div>

        <div class="list-div">
            <ul id="list" class= "list"></ul>
        </div>
    </body>
</html>

<script>
    loadLists();
</script>