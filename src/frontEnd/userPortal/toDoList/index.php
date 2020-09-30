<?php
    session_start();

    if(!isset($_SESSION) || $_SESSION["loggedIn"] != true){
        header( "Location: ../login.php");
        die;
    }
?>

<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="styleToDoList.css">
    </head>
    <body>
        <?php include '../header.php'; ?>

        <div class="header-div">
            <div>
                <lable class= "Headline" >Organizer</lable>
            </div>
            <div class="placeholder"></div>
            <ul class= "nav-links" id="toDoNav">
                <li><button onclick="changeList('toDoList')" class="font">To Do List</button></li>
            </ul>
            <button onclick="newList()" class="settings-btn">New List</button>
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

    loadList(listName);

    async function addNewItem(){
        const token = await getCo();
        let item = prompt("Next ToDo's");

        var xml = new XMLHttpRequest();
        xml.open('POST', "https://sebastian-web.de/api/v1/addElementToUserList");
        xml.setRequestHeader('authorization', token);
        xml.setRequestHeader("Content-Type", "application/json");
        xml.send(JSON.stringify({ "name": listName,"item": item }));
        xml.onreadystatechange = function () {
            if (xml.readyState == 4 && xml.status == 200) {
                loadList(listName);
            }
        }
    }
    async function removeItem(item){
        const token = await getCo();

        var xml = new XMLHttpRequest();
        xml.open('POST', "https://sebastian-web.de/api/v1/removeElementFromUserList");
        xml.setRequestHeader('authorization', token);
        xml.setRequestHeader("Content-Type", "application/json");
        xml.send(JSON.stringify({ "name": listName,"item": item }));
        xml.onreadystatechange = function () {
            if (xml.readyState == 4 && xml.status == 200) {
                loadList(listName);
            }
        }
    }

    async function loadList(listName) {
        console.log("loading..");
        const token = await getCo();
        const dataPacket = {
            "name": listName
        };

        var xml = new XMLHttpRequest();
        xml.open('POST', "https://sebastian-web.de/api/v1/getUserList");
        xml.setRequestHeader('authorization', token);
        xml.setRequestHeader("Content-Type", "application/json");
        xml.send(JSON.stringify({ dataPacket }));

        xml.onreadystatechange = function () {
            if (xml.readyState == 4 && xml.status == 200) {
                const data = JSON.parse(xml.responseText);

                table_constructor(data);
            }
        }
    }

    function newList() {
        let listName = prompt("List Name");

        document.getElementById('toDoNav').innerHTML += `<li><button onclick="changeList('${listName}')" class="font">${listName}</button></li>`;
    }

    function table_constructor(list){
        document.getElementById("list").innerHTML = "";

        list.forEach((e,i)=> {
            document.getElementById("list").innerHTML += `<li>${e} <button onclick="removeItem('${e}')" class="can">X</button></li>`;
        });
    }


    function changeList(name) {
        listName = name;

        window.document.title = listName;
    }

    function getCo(){
        var co = document.cookie.split(";"),
            out = "none";
        co.forEach(e=>{
            if(e.startsWith("token=")){
                e = e.slice(6);

                out = e;
            }
        });
        return out;
    }
</script>