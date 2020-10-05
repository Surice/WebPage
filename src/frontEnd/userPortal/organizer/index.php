<?php
    session_start();

    if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
        header( "Location: ../login.php");
        die;
    }
?>

<html>
    <head>
        <!-- Bootstrap Import -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <!-- End Bootstrap Import -->

        <!-- FontAwesome Import -->
            <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
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
    var listName = 'ToDoList';
    window.document.title = listName;

    loadLists();
    loadList(listName);
</script>