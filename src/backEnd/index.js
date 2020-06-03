const express = require('express');
const exp = express();
const bodyParser = require('body-parser');
const fs = require('fs');

const userInfo = JSON.parse(fs.readFileSync(`${__dirname}/userInfo.json`, 'utf-8').toString());
const port = 999;

exp.use(bodyParser.json());


exp.post('/userInfo', function(req, res){
    const data = req.body;
    console.log(req.body);
//    saveUserData(data);

    res.status(400).end();
});

exp.listen(port, function(){
    console.log(`listen on port ${port}`);
})


async function saveUserData(data){
    var today = new Date();
    today = await `${today.getHours()}:${today.getMinutes()} (${today.getDay()}/${today.getMonth()+1}/${today.getFullYear()})`;

    userInfo[today] = new Array();

    for (i in data){
        userInfo[today].push(data[i]);
    }   
    userInfo[today].splice(0,1);  
    fs.writeFileSync(`${__dirname}/userInfo.json`, JSON.stringify(userInfo));
}