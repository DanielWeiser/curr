const MongoClient = require('mongodb').MongoClient;
const assert = require('assert');


const mongo_url = 'mongodb://localhost:27017';

MongoClient.connect(mongo_url, { useNewUrlParser: true }, function(err, client) {
    assert.equal(null, err);
    console.log("Connected successfully to server");
    const mongo_db = client.db('rates');
    findDocuments(mongo_db, function() {
        client.close();
    });
});

const findDocuments = function(db, callback) {
    // Get the documents collection
    const collection = db.collection('curr_rates');
    // Find some documents
    collection.find({}).project({_id: 0}).sort({_id: -1}).limit(8).toArray(function(err, docs) { //last 8 records
        assert.equal(err, null);
        console.log(docs.reverse());
        callback(docs);
    });
}