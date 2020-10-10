const fs = require('fs');
const mysql = require('../node_modules/mysql');

const config = JSON.parse(fs.readFileSync(`${__dirname}/../config.json`))

const db = mysql.createPool({
    host: 'localhost',
    user: config.dbUser,
    password: config.dbPassword,
    database: 'Sebastian-web'
});

module.exports = db;