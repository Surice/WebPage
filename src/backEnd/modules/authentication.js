const fs = require('fs');
const jwt = require('jsonwebtoken');

const config = JSON.parse(fs.readFileSync(`${__dirname}/../config.json`, "utf-8").toString());

module.exports = function (req, res, next) {
    try{
        const token = req.headers.authorization;
        const decodedToken = jwt.verify(token, config.apiSecret);

        if(decodedToken){
            req.payload = decodedToken;
            next();
        }else{
            res.status(403).json({
              error: 'invalid Token'
            });
        }
    }catch{
        res.status(401).json({
            error: 'invalid request'
        });
    }
}