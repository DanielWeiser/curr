const http = require('http');
const https = require('https');
const fs = require('fs');
var con = require('./db');  //db connection
var Pusher = require('pusher');
const MongoClient = require('mongodb').MongoClient;
const assert = require('assert');
 
//Mongo connection URL
const mongo_url = 'mongodb://user:password@localhost:27017/rates';

/*
 * API keys
 */
//var access_key = 'c657d3c106c05395b751961d9f4b7e6a';
//var access_key_currconv = 'd374bad623885a8f9283'; 
var access_key_currconv = '6064d6ff13d8a516cec5';
var update_flag = 0;

var pusher = new Pusher({
  appId: '816263',
  key: '02905f0e5b161db67caa',
  secret: 'd7a15e2ed25fe9f52943',
  cluster: 'eu',
  encrypted: true
});
/*
 * array of currencies
 */
var currency = ['RUB', 'AUD', 'EUR', 'BRL', 'BGN', 'CAD', 'CNY', 'COP', 'CZK', 'INR', 'JPY'];
//var currency = ['RUB', 'AUD'];
var curr, obj, rate, sql;
var url_arr = [];
var curr_arr = [];
var history = {};

/*
 * Push URLs and JSON keys to arrays
 */
currency.forEach(element => {
    url = 'https://free.currconv.com/api/v7/convert?q=' + element + '_USD&compact=ultra&apiKey=' + access_key_currconv;
    console.log(url);
    curr = element + '_USD';
    url_arr.push(url);
    curr_arr.push(curr);
});

/**
 * set history array (history - array of rates with code key)
 */
function UpdateRate(index) {
    return new Promise((resolve, reject) => {
        https.get(url_arr[index], (res) => {
            res.on('data', (d) => {
                obj = JSON.parse(d);
                rate = obj[curr_arr[index]];
                if(typeof rate == 'undefined') {
                    throw new Error("wrong request");
                }
                history[currency[index]] = rate;
                con.query("update currency set rate = ? where code = ?;", [rate, currency[index]], (err, data) => {
                    if (err) 
                        throw err;
                    resolve(data);
                    console.log('successfuly updated');
                    update_flag++;
                });
            });
        });
    });
}

const insertDocuments = function(db, data, callback) {
    // Get the documents collection
    const collection = db.collection('curr_rates');
    // Insert some documents
    collection.insertOne(data, function(err, result) {
        assert.equal(err, null);
        console.log("Rates inserted");
        callback(result);
    });
}

const findDocuments = function(db, callback) {
    // Get the documents collection
    const collection = db.collection('curr_rates');
    // Find some documents
    collection.find({}).project({_id: 0}).sort({_id: -1}).limit(8).toArray(function(err, docs) { //last 8 records
        assert.equal(err, null);
        console.log(docs);
        con.end();
        wr_flag = 1;
        pusher.trigger('node', 'ResponseToRequest', {
            "docs": docs.reverse()
        });
        callback(docs);
    });
}

// var test_data = [];
// for (let i = 0; i < 10; i++) {
//     test_data[i] = Math.floor(Math.random() * 10) + 1;
// }
// console.log(test_data);
// pusher.trigger('node', 'ResponseToRequest', {
//     test_data
// });

var today = new Date();
var wr_flag = 0;
var json_hist = [];

con.connect(function(err) {
    if (err) 
        throw err;
    console.log("connected");
    for (let index = 0; index < currency.length; index++) {
        UpdateRate(index)
        .then(function(){
            //if(wr_flag == 0 && Object.keys(history).length == currency.length) {
            if(wr_flag == 0 && update_flag == currency.length) {
                /*
                * Read old currencies rate in array
                * array.push new rate and write to json file
                */
                // fs.readFile('history.json', (err, data) => {
                //     if (err) 
                //         throw err;
                //     json_hist = JSON.parse(data);
                //     if(json_hist.length >= 8) //max 8 elements in json file
                //         json_hist.shift();
                //     history.time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds(); //lables
                //     json_hist.push(history);
                //     pusher.trigger('node', 'ResponseToRequest', {
                //         json_hist
                //     });
                //     var json = JSON.stringify(json_hist);
                //     fs.writeFileSync('history.json', json, 'utf8');
                //     wr_flag = 1;
                //     con.end();
                // });
                /*
                * MongoDB connect and insert/find operations
                *
                */
                MongoClient.connect(mongo_url, function(err, client) {
                    assert.equal(null, err);
                    console.log("Connected successfully to server");
                    const mongo_db = client.db('rates');
                    history.time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds(); //lables
                    insertDocuments(mongo_db, history, function() {
                        findDocuments(mongo_db, function() {
                            client.close();
                        });
                    });
                });
            }
        });
    }
});


