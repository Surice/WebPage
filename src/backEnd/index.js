#!/usr/bin/env node

const express = require('express');
const exp = express();
const bodyParser = require('body-parser');
const fs = require('fs');
const XMLHttpRequest = require('xmlhttprequest').XMLHttpRequest;
const jwt = require('jsonwebtoken');


const config = JSON.parse(fs.readFileSync(`${__dirname}/config.json`, "utf-8").toString());
var userInfo = JSON.parse(fs.readFileSync(`${__dirname}/userInfo.json`, 'utf-8').toString());

const port = 8082;
const bURL = '/api/v1';

exp.use(bodyParser.json());


exp.get(`${bURL}/userInfo`, function(req, res){
    var ip = req.headers['x-forwarded-for'];
    if(ip != "::ffff:127.0.0.1" && ip != "170.133.2.232"){
        saveUserData(ip);
    }
    res.status(200).end();
});


exp.get(`${bURL}/getUsers`, function(req, res){
    //hard gecodet. fehlt user index
    if(req.headers.authorization && jwt.verify(req.headers.authorization, config.apiSecret) == config.user){
        res.status(200).send(userInfo).end();
    }else{
        res.status(401).json({"error": "Token Invalid!"}).end();
    }
});


exp.post(`${bURL}/users`, function(req, res){
    if(req.body.username){
        const user = req.body.username;

        var token = jwt.sign(user, config.apiSecret);
        res.status(200).json({ "token": token }).end();
    }
});


exp.get(`${bURL}/steamG`, function(req, res){
    const response = fs.readFileSync(`${__dirname}/modules/steamGames.json`);

    res.send(response);
});


exp.get(`${bURL}/test`, function(req, res){
    res.status(200);
    res.send("Succsess").end();
});


exp.listen(port, function(){
    console.log(`listen on port ${port}`);
});


async function saveUserData(data){
    var today = new Date();

    var xml = new XMLHttpRequest();
    xml.open('GET', `https://ipinfo.io/${data}?token=${config.token}`, true);
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
            
            today = await `${hou}:${min} (${today.getDate()}/${today.getMonth()+1}/${today.getFullYear()})`;

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
            console.log(xml.status);
        }
    };



    
}