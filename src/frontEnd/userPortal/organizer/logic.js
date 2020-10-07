async function addNewItem(){
    const token = await getCo();
    let item = prompt("Next ToDo's");
    if(!item) return;

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


async function addNewList() {
    const token = await getCo();
    let newListName = prompt("List Name");
    if(!newListName) return;

    var xml = new XMLHttpRequest();
    xml.open('POST', "https://sebastian-web.de/api/v1/createUserList");
    xml.setRequestHeader('authorization', token);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send(JSON.stringify({ "name": newListName }));

    xml.onreadystatechange = function () {
        if (xml.readyState == 4 && xml.status == 200) {
            loadLists();
        }
    }
}


function changeList(name) {
    if(name === true){
        name = document.getElementById('nav-links-sel').value;
    }

    listName = name;

    window.document.title = listName;

    setHighlighting(listName);
    loadList(listName);
}

function table_constructor(list){
    document.getElementById("list").innerHTML = "";

    list.forEach((e,i)=> {
        document.getElementById("list").innerHTML += `<li><p class="liElement">${e}</p> <button onclick="removeItem('${e}')" class="can">X</button></li>`;
    });
}

function navLinkConsturctor(lists){
    document.getElementById('nav-links').innerHTML = "";
    document.getElementById('nav-links-sel').innerText = "";

    lists.forEach( e =>{
        document.getElementById('nav-links').innerHTML += `<li><a onclick="changeList('${e}')" id="${e}" class="listsItem">${e}</a></li>`;
        document.getElementById('nav-links-sel').innerHTML += `<option><a value="${e}" class="selItem">${e}</a></option>`;
    });
}

async function loadList(listName) {
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

async function loadLists(){
    const token = await getCo();

    var xml = new XMLHttpRequest();
    xml.open('GET', "https://sebastian-web.de/api/v1/getUserLists");
    xml.setRequestHeader('authorization', token);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send();

    xml.onreadystatechange = async function() {
        if (xml.readyState == 4 && xml.status == 200) {
            const data = JSON.parse(xml.responseText);

            await navLinkConsturctor(data);
            await changeList(data[0]);
            setHighlighting(listName);
        }
    }
}

function setHighlighting(listName) {
    const alt = document.getElementsByClassName('active')[0];
    if(alt){
        alt.className = alt.className.replace('active', ' ');
    }

    const newList = document.getElementById(listName);
    newList.className +=' active';
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