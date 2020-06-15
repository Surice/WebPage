const express = require('express');
const exp = express();
const bodyParser = require('body-parser');
const fs = require('fs');
const XMLHttpRequest = require('xmlhttprequest').XMLHttpRequest

const port = 9999;
const urlInt = '192.168.178.38:999';


exp.use(bodyParser.json());


exp.get('/userInfo', function(req, res){
    var data = req.connection.remoteAddress;

    console.log(data);
    /*
    var xml = new XMLHttpRequest();
    xml.open('POST', `${urlInt}/userInfo`);
    xml.send(data);
    xml.onreadystatechange = function(){
        if(this.readyState == 4 && this.status != 200){
            console.log(this.status);
        }
    }
    */
    res.status(200).end();
});


//client on function
exp.listen(port, function(){
    console.log(`listen on port ${port}`);
});