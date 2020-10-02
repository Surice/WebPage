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

        <meta charset="utf-8"/>
        <link rel="shortcut icon" type="image/x-icon" href="../../img/Surice_logo_ti.ico">
        <link rel="stylesheet" href="style.css">
        <script src="./logic.js"></script>
    </head>
    <body>
        <?php include '../header.php'; ?>

        <div class="header-div">
            <div>
                <lable class= "Headline" >Organizer</lable>
            </div>
            <div class="placeholder"></div>
            <ul class= "nav-links" id="toDoNav">
            </ul>
            <button onclick="addNewList()" class="settings-btn">New List</button>
            <button onclick="addNewItem()" class="addBtn">New Item</button>
        </div>


        <div class="list-div">
            <ul id="list" class= "ToDoListe"></ul>
        </div>
    </body>
</html>

<script>
    var listName = 'toDoList';
    window.document.title = listName;

    loadLists();
    loadList(listName);
</script>