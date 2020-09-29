#!/usr/bin/env node
const express = require('express');
const exp = express();
const bodyParser = require('body-parser');
const fs = require('fs');
const XMLHttpRequest = require('xmlhttprequest').XMLHttpRequest;
const jwt = require('jsonwebtoken');
const { dir } = require('console');
const request = require('request');
const path = require('path');

const db = require(`${__dirname}/modules/database`);

const auth = require(`${__dirname}/modules/authentication.js`);


const config = JSON.parse(fs.readFileSync(`${__dirname}/config.json`, "utf-8").toString());
var userInfo = JSON.parse(fs.readFileSync(`${__dirname}/userInfo.json`, 'utf-8').toString());

const port = 8082;
const bURL = '/api/v1';

exp.use(bodyParser.json());

exp.get(`${bURL}/getImg.jpg`, auth, function(req, res){
    if(req.payload.role == "Developer"){
        const stream = fs.createWriteStream(`${__dirname}/img/save.jpg`);
        var reqStream = request(config.camRequestUrl).pipe(stream);

        reqStream.on('finish', function () {
            const url = path.join(__dirname, "/img");
            res.sendFile('/save.jpg', {root: url});
        });
    }
});


exp.post(`${bURL}/userInfo`, function(req, res){
    var ip = req.headers['x-forwarded-for'];
    if(ip != "::ffff:127.0.0.1" /*&& ip != "170.133.2.232"*/){
        let saveUserData = require(`${__dirname}/modules/saveUserData.js`);
        saveUserData(ip, req.body);
    }
    res.status(200).send("OK").end();
});


exp.get(`${bURL}/getUsers`, auth, function(req, res){
    if(req.payload.role == "Developer") {
        res.status(200).send(userInfo).end();
    }
});

exp.get(`${bURL}/getUserAccounts`, auth, function (req, res) {
    if(req.payload.role == "Developer"){
        let sql = 'SELECT * FROM user_accounts';
        db.query(sql, function (err, data, next) {
            if(err) throw err;

            res.status(200).json( data );
        });
    }
});

exp.post(`${bURL}/delUserAccount`, auth, function (req, res) {
    if(req.payload.role == "Developer"){
        let sql = 'DELETE FROM user_accounts WHERE id = ?'
        let value = req.body.id;
        db.query(sql, value, function (err, data, next) {
            if(err) throw err;

            res.status(200).json({state: "Success"});
        });
    }
});


exp.post(`${bURL}/getToken`, function(req, res){
    if(req.body.username){
        const id = req.body.userId,
            user = req.body.username,
            role = req.body.role;

        var token = jwt.sign({userId: id, username: user, role: role}, config.apiSecret);
        res.status(200).json({ "token": token }).end();
    }
});

exp.get(`${bURL}/getUserAccount`, auth, function (req, res) {
        let sql = 'SELECT * FROM user_accounts WHERE id = ?';
        const value = req.payload.userId;
        db.query(sql, value, function (err, data, next) {
            if(err) throw err;

            res.status(200).json( data );
        });
});

exp.post(`${bURL}/saveUserAccountChanges`, auth, function (req, res) {
    let sql = 'UPDATE user_accounts SET email = ?, firstname = ?, lastname = ? WHERE id = ?';

    const userValues = req.body.values;
    const values = [userValues.email, userValues.firstname, userValues.lastname, req.payload.userId];

    db.query(sql, values, function (err, data, next) {
        if(err) throw err;

        res.status(200).send('success');
    });
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