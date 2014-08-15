var db = require('../libs/db-connect')();
var Schema = require('mongoose').Schema;

var adSchema = Schema({
}, { strict: false });

var Ad = db.model('Ad', adSchema);

var cepSchema = Schema({
}, { strict: false });

var Cep = db.model('Cep', cepSchema);

module.exports.Ad = Ad;
module.exports.Cep = Cep;