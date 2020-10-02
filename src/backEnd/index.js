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



exp.post(`${bURL}/userInfo`, function(req, res){
    var ip = req.headers['x-forwarded-for'];
    if(ip != "::ffff:127.0.0.1" /*&& ip != "170.133.2.232"*/){
        let saveUserData = require(`${__dirname}/modules/saveUserData.js`);
        saveUserData(ip, req.body);
    }
    res.status(200).send("OK").end();
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


exp.get(`${bURL}/getUsers`, auth, function(req, res){
    if(req.payload.role == "Developer") {
        res.status(200).send(userInfo).end();
    }
});

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

exp.get(`${bURL}/getUserAccounts`, auth, function (req, res) {
    if(req.payload.role == "Developer"){
        let sql = 'SELECT * FROM user_accounts';
        db.query(sql, function (err, data, next) {
            if(err) throw err;

            res.status(200).json( data );
        });
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

exp.post(`${bURL}/saveUserAccountChanges`, auth, function (req, res) {
    let sql = 'UPDATE user_accounts SET email = ?, firstname = ?, lastname = ? WHERE id = ?';

    const userValues = req.body.values;
    const values = [userValues.email, userValues.firstname, userValues.lastname, req.payload.userId];

    db.query(sql, values, function (err, data, next) {
        if(err) throw err;

        res.status(200).send('success');
    });
});

exp.post(`${bURL}/createUserList`, auth, function (req, res) {
    let sql = 'SELECT id FROM user_accounts WHERE email = ?';
    const value = req.payload.username;

    db.query(sql, value, function (err, data, next) {
        const listName = req.body.name,
            ownerId = data[0].id;

        let sql = 'SELECT * FROM userList WHERE name = ? AND ownerId = ?';
        const values = new Array(listName, ownerId);

        db.query(sql, values, function (err, data, next) {
            if(err) throw err;

            if(data.length != 0){
                res.status(400).json({error: "list already exist"});
                return;
            }
        });

        sql = 'INSERT INTO userList(`name`, `ownerId`) VALUES(?)';

        db.query(sql, [values], function (err, data, next) {
            if (err) throw err;

            res.status(200).send();
        });
    });
});

exp.post(`${bURL}/addElementToUserList`, auth, function (req, res) {
    let sql = 'SELECT id FROM user_accounts WHERE email = ?';
    const value = req.payload.username;

    db.query(sql, value, function (err, data, next) {
        let sql = 'SELECT id FROM userList WHERE ownerId = ? AND name = ?';
        const values = new Array(data[0].id, req.body.name);

        db.query(sql, values, function (err, data, next) {
            const item = req.body.item;
            let sql = 'INSERT INTO userListItems(`item`, `listId`) VALUES(?)';
            const values = new Array(item, data[0].id);

            db.query(sql, [values], function (err, data, next) {
                if (err) throw err;

                res.status(200).send('success');
            });
        });
    });
});

exp.post(`${bURL}/removeElementFromUserList`, auth, function (req, res) {
    let sql = 'SELECT id FROM user_accounts WHERE email = ?';
    const value = req.payload.username;

    db.query(sql, value, function (err, data, next) {
        let sql = 'SELECT id FROM userList WHERE ownerId = ? AND name = ?';
        const values = new Array(data[0].id, req.body.name);

        db.query(sql, values, function (err, data, next) {
            const item = req.body.item;
            let sql = 'DELETE FROM userListItems WHERE listId = ? AND item = ?';
            const values = new Array(data[0].id, item);

            db.query(sql, values, function (err, data, next) {
                if (err) throw err;

                res.status(200).send('success');
            });
        });
    });
});

exp.get(`${bURL}/getUserLists`, auth, function (req, res) {
    let sql = 'SELECT id FROM user_accounts WHERE email = ?';
    const value = req.payload.username;

    db.query(sql, value, function (err, data, next) {
        let sql = 'SELECT name FROM userList WHERE ownerId = ?';
        const value = data[0].id;

        db.query(sql, value, function (err, data, next) {
            if (err) throw err;

            var lists = new Array();
            data.forEach(e=>{
               lists.push(e.name);
            });

            res.status(200).json( lists );
        });
    });
});

exp.post(`${bURL}/getUserList`, auth, function (req, res) {
    let sql = 'SELECT id FROM user_accounts WHERE email = ?';
    const value = req.payload.username;

    db.query(sql, value, function (err, data, next) {
        let sql = 'SELECT id FROM userList WHERE ownerId = ? AND name = ?';
        const values = new Array(data[0].id, req.body.dataPacket.name);
        db.query(sql, values, function (err, data, next) {
            let sql = 'SELECT item FROM userListItems WHERE listId = ?'
            const value = data[0].id;

            db.query(sql, value, function (err, data, next) {
                if (err) throw err;
                var list = new Array();
                data.forEach(e => {
                   list.push(e.item);
                });

                res.status(200).json( list );
            });
        });
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