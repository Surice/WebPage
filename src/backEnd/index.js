const express = require('express');
const exp = express();
const bodyParser = require('body-parser');
const fs = require('fs');
const XMLHttpRequest = require('xmlhttprequest').XMLHttpRequest;


const config = JSON.parse(fs.readFileSync(`${__dirname}/config.json`, "utf-8").toString());
var userInfo = JSON.parse(fs.readFileSync(`${__dirname}/userInfo.json`, 'utf-8').toString());
const port = 999;

exp.use(bodyParser.json());


exp.post('/userInfo', function(req, res){
    var data = req.body;
    saveUserData(data);

    res.status(400).end();
});
exp.get('/getUser', function(req, res){
    res.send(userInfo);
});
exp.get('/steamG', function(req, res){
    steamSearch = require(`${__dirname}/modules/steamSearch.js`);
    let response = steamSearch();

    res.send(response);
});


exp.listen(port, function(){
    console.log(`listen on port ${port}`);
});


async function saveUserData(data){
    var today = new Date(),
    data = data.ip;

    var xml = new XMLHttpRequest();
    xml.open('GET', `https://ipinfo.io/${data}?token=${token}`, true);
    xml.send();
    xml.onreadystatechange = async function(){
        if(xml.readyState == 4 && xml.status == 200){
            var data = JSON.parse(xml.responseText);

            if(today.getMinutes() < 10){
                var min = "0"+today.getMinutes();
            }else{var min = today.getMinutes()};
            if(today.getHours() < 10){
                var hou = "0"+today.getHours();
            }else{var hou = today.getHours()};
            
            today = await `${hou}:${min} (${today.getDay()}/${today.getMonth()+1}/${today.getFullYear()})`;

            userInfo[today] = new Array();
;
            for (i in data){
                userInfo[today].push(data[i]);
            }

            var ip = userInfo[today].splice(0,1);
            var domain = userInfo[today].splice(0,1);
            console.log(ip);
            fs.writeFileSync(`${__dirname}/userInfo.json`, JSON.stringify(userInfo));
        }else{
            console.log(xml.status)
        }
    };



    
}