var express = require('express');
var router = express.Router();
var mongoose = require('mongoose');
var ObjectId = mongoose.Types.ObjectId;

mongoose.connect('mongodb://localhost/netPromocao');

var adSchema = mongoose.Schema({
}, { strict: false });

var Ad = mongoose.model('Ad', adSchema);

var cepSchema = mongoose.Schema({
}, { strict: false });

var Cep = mongoose.model('Cep', cepSchema);

router.post('/', function (req, res) {
	var anuncio = new Ad(req.body);

	Cep.findOne({CEP: Number(anuncio.get('cep').replace('-', ''))}, function (err, cep) {

		anuncio.set('cepAtende', cep !== null);

		res.cookie('anuncio', anuncio, { maxAge: 900000, httpOnly: true });

		anuncio.save();

		if (anuncio.get('cliente-net') === 'sim') {
			res.redirect('/net-promocao/conversao-cliente.html');
		} else {
			res.redirect('/net-promocao/cadastro-final.html');
		}
	});
});

router.post('/cadastro', function (req, res) {
	var anuncio = new Ad(req.cookies.anuncio);

	Ad.findOneAndUpdate({_id: req.cookies.anuncio._id}, req.body, function (err, place) {
		if (anuncio.get('cepAtende')) {
			res.redirect('/net-promocao/conversao-nao-cliente.html');
		} else {
			res.redirect('/net-promocao/nao-atende.html');
		}
	});

});

module.exports = router;