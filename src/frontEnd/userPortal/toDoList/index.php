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

    async function loadList(listName) {
        const token = await getCo();

        var xml = new XMLHttpRequest();
        xml.open('GET', "https://sebastian-web.de/api/v1/getUserList");
        xml.setRequestHeader('authorization', token);
        xml.setRequestHeader("Content-Type", "application/json");
        xml.send(JSON.stringify({"name": listName}));
        xml.onreadystatechange = function () {
            if (xml.readyState == 4 && xml.status == 200) {
                const data = JSON.parse(xml.responseText)[0];

                table_constructor(data);
            }
        }
    }

    function addNewItem(){
        
        let item = prompt("Next ToDo's");

        list.push(item);

        if(item == null || item == "") {
            list.pop(item);
        }

        table_constructor(list);
    }

    function newList() {
        let listName = prompt("List Name");

        document.getElementById('toDoNav').innerHTML += `<li><button onclick="changeList('${listName}')" class="font">${listName}</button></li>`;
    }

    function table_constructor(list){
        document.getElementById("list").innerHTML = "";

        list.forEach((e,i)=> {
            document.getElementById("list").innerHTML += `<li>${e} <button onclick="removeItem(${i})" class="can">X</button></li>`;
        });
    }
    function removeItem(index){

        list.splice(index, 1)

        table_constructor(list)
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