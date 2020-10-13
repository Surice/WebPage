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

async function getProfileValues(){
    const token = await getCo();

    xml = new XMLHttpRequest();
    xml.open('GET', 'https://sebastian-web.de/api/v1/getUserAccount');
    xml.setRequestHeader('authorization', token);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send();
    xml.onreadystatechange = function() {
        if (xml.readyState == 4 && xml.status == 200) {
            const data = JSON.parse(xml.responseText)[0];

            document.getElementById('mail').value = data.email;
            document.getElementById('firstN').value = data.firstname;
            document.getElementById('lastN').value = data.lastname;
        } else if (xml.readyState == 4) {
            console.log(xml.status);
        }
    }
}

async function saveSettings(){
    const token = await getCo();

    xml = new XMLHttpRequest();
    xml.open('GET', 'https://sebastian-web.de/api/v1/getUserAccount');
    xml.setRequestHeader('authorization', token);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send();
    xml.onreadystatechange = function() {
        if (xml.readyState == 4 && xml.status == 200) {
            const data = JSON.parse(xml.responseText)[0];
            const values = {
                email: document.getElementById('mail').value,
                firstname: document.getElementById('firstN').value,
                lastname: document.getElementById('lastN').value
            };

            if(checkChanges(data, values)){
                xml = new XMLHttpRequest();
                xml.open('POST', 'https://sebastian-web.de/api/v1/saveUserAccountChanges');
                xml.setRequestHeader('authorization', token);
                xml.setRequestHeader("Content-Type", "application/json");
                xml.send(JSON.stringify({values}));
                xml.onreadystatechange = function() {
                    if (xml.readyState == 4 && xml.status == 200) {
                        
                    }
                }
            }
        } else if (xml.readyState == 4) {
            console.log(xml.status);
        }
    }
}
function checkChanges(item1, item2) {
    var res = false;

    for (e in item1){
        if(item1[e] != item2[e]) res = true;
        if(item2[e] == '') {
            res = false;

            throw 'value cannot be empty';
        }
    }
    return res;
}

async function changePassword(){
    const token = await getCo();

    xml = new XMLHttpRequest();
    xml.open('GET', 'https://sebastian-web.de/api/v1/getUserAccount');
    xml.setRequestHeader('authorization', token);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send();
    xml.onreadystatechange = function() {
        if (xml.readyState == 4 && xml.status == 200) {
            const data = JSON.parse(xml.responseText)[0];
            const values = {
                oldPswrd: document.getElementById('cPswrd').value,
                newPswrd: document.getElementById('nPswrd').value,
                repeatedPswrd: document.getElementById('rNPwswrd').value
            };

            if(values.oldPswrd != data.password){
                console.log(data.password);
                throw 'password Wrong';
                return;
            }
            if(values.newPswrd == ''){
                throw 'new password must be set';
                return;
            }
            if(values.newPswrd != values.repeatedPswrd){
                throw 'repeated password doesnt match';
                return;
            }

        }
    }
}

async function getAllLists(){
    const token = await getCo();

    var xml = new XMLHttpRequest();
    xml.open('GET', "https://sebastian-web.de/api/v1/getUserLists");
    xml.setRequestHeader('authorization', token);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send();

    xml.onreadystatechange = async function() {
        if (xml.readyState == 4 && xml.status == 200) {
            const data = JSON.parse(xml.responseText);

            document.getElementById('lists').innerHTML = "";

            data.forEach(e => {
                document.getElementById('lists').innerHTML += `
                        <li class="list">
                            ${e}
                            <div class="btn">
                                <button class="btn-rename" onclick="changeListName('${e}')">...</button>
                                <select class="btn-color" onchange="" style="display: none">
                                    <option style="background-color: rgb(0,0,255)">Blue</option>
                                    <option style="background-color: rgb(0,255,0)">Green</option>
                                    <option style="background-color: rgb(255,0,0)">Red</option>
                                    <option style="background-color: rgb(240,120,0)">Orange</option>
                                </select>
                                <button class="btn-delete" onclick="delList('${e}')">X</button>
                            </div>
                        </li>
                    `;
            });
        }
    }
}
async function changeListName(listName){
    const token = await getCo();

    const newName = prompt(`${listName} umbenennen zu:`);
    if(!newName) return;

    var xml = new XMLHttpRequest();
    xml.open('POST', "https://sebastian-web.de/api/v1/updateUserListName");
    xml.setRequestHeader('authorization', token);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send(JSON.stringify({name: newName, oldName: listName}));

    xml.onreadystatechange = async function() {
        if (xml.readyState == 4 && xml.status == 200) {
            location.reload();
        }
    }
}
async function newList() {
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
            getAllLists();
        }
    }
}
async function delList(listName) {
    const token = await getCo();

    if(confirm(`bist du sicher, dass du ${listName} löschen willst?`)) {
        var xml = new XMLHttpRequest();
        xml.open('POST', "https://sebastian-web.de/api/v1/deleteUserList");
        xml.setRequestHeader('authorization', token);
        xml.setRequestHeader("Content-Type", "application/json");
        xml.send(JSON.stringify({name: listName}));

        xml.onreadystatechange = async function () {
            if (xml.readyState == 4 && xml.status == 200) {
                location.reload();
            }
        }
    }
}