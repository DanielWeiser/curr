const mysql = require('mysql');

var con = mysql.createConnection({
    host: '127.0.0.1',
    user: "user",
    password: "password",
    database: "currency"
});
module.exports = con;
