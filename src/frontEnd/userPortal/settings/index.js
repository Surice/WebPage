async function getValues(){
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