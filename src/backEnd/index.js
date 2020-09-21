#!/usr/bin/env node
const express = require('express');
const exp = express();
const bodyParser = require('body-parser');
const fs = require('fs');
const XMLHttpRequest = require('xmlhttprequest').XMLHttpRequest;
const jwt = require('jsonwebtoken');
const { dir } = require('console');
const request = require('request');

const db = require(`${__dirname}/modules/database`);

const auth = require(`${__dirname}/modules/authentication.js`);


const config = JSON.parse(fs.readFileSync(`${__dirname}/config.json`, "utf-8").toString());
var userInfo = JSON.parse(fs.readFileSync(`${__dirname}/userInfo.json`, 'utf-8').toString());

const port = 8082;
const bURL = '/api/v1';

exp.use(bodyParser.json());

exp.get(`${bURL}/getImg`, function(req, res){
    if(req.headers.authorization && jwt.verify(req.headers.authorization, config.apiSecret) == config.user){
        request(config.camRequestUrl).pipe(fs.createWriteStream(`${__dirname}/img/save.jpg`));

        res.sendFile(`${__dirname}/img/save.jpg`);
    }else{
        res.status(401).json({"error": "Token Invalid!"}).end();
    }
});


exp.post(`${bURL}/userInfo`, function(req, res){
    var ip = req.headers['x-forwarded-for'];
    if(ip != "::ffff:127.0.0.1" /*&& ip != "170.133.2.232"*/){
        saveUserData(ip, req.body);
    }
    res.status(200).send("OK").end();
});


exp.get(`${bURL}/getUsers`, auth, function(req, res){
    if(req.payload.role == "Developer") {
        res.status(200).send(userInfo).end();
    }
});

exp.get(`${bURL}/getUserAccount`, auth, function (req, res) {
    if(req.payload.role == "Developer"){
        let sql = 'SELECT * FROM user_accounts';
        db.query(sql, function (err, data, next) {
            if(err) throw err;

            res.status(200).json( data );
        })
    }
});

exp.post(`${bURL}/delUserAccount`, auth, function (req, res) {
    if(req.payload.role == "Developer"){
        let sql = 'DELETE FROM user_accounts WHERE id = ?'
        let value = req.body.id;
        db.query(sql, value, function (err, data, next) {
            if(err) throw err;

            res.status(200).json({state: "Success"});
        })
    }
})


exp.post(`${bURL}/getToken`, function(req, res){
    if(req.body.username){
        const user = req.body.username;
        const role = req.body.role;

        var token = jwt.sign({username: user, role: role}, config.apiSecret);
        res.status(200).json({ "token": token }).end();
    }
});


exp.get(`${bURL}/steamG`, function(req, res){
    const response = fs.readFileSync(`${__dirname}/modules/steamGames.json`);

    res.send(response);
});


exp.get(`${bURL}/test`, function(req, res){
    res.status(200);
    res.send("OK").end();
});


exp.listen(port, function(){
    console.log(`listen on port ${port}`);
});


async function saveUserData(ip, user){
    var today = new Date();

    var xml = new XMLHttpRequest();
    xml.open('GET', `https://ipinfo.io/${ip}?token=${config.token}`, true);
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

            let checkDevice = require(`${__dirname}/modules/checkDevice.js`);
            await checkDevice(user);

            var ip = userInfo[today].splice(0,1);
            var domain = userInfo[today].splice(0,1);
            console.log(ip);
            fs.writeFileSync(`${__dirname}/userInfo.json`, JSON.stringify(userInfo));
        }else{
            console.log(xml.status);
        }
    };



    
}