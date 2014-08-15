var express = require('express');
var router = express.Router();
var Cep = require('../models/anuncios').Cep;
var Ad = require('../models/anuncios').Ad;

router.post('/', function (req, res) {
	var anuncio = new Ad(req.body);

	Cep.findOne({CEP: Number(anuncio.get('cep').replace('-', ''))}, function (err, cep) {

		anuncio.set('cepAtende', cep !== null);
		anuncio.set('cidade', cep.get('CIDADE'));
		anuncio.set('estado', cep.get('UF'));
		res.cookie('anuncio', anuncio, { maxAge: 900000, httpOnly: true });

		anuncio.save();

		if (anuncio.get('cliente-net') === 'sim') {
			res.redirect('/conversao-cliente.html');
		} else {
			res.redirect('/cadastro-final');
		}
	});
});

router.post('/cadastro', function (req, res) {
	var anuncio = new Ad(req.cookies.anuncio);

	Ad.findOneAndUpdate({_id: req.cookies.anuncio._id}, req.body, function (err, place) {
		if (anuncio.get('cepAtende')) {
			res.redirect('/conversao-nao-cliente.html');
		} else {
			res.redirect('/nao-atende.html');
		}
	});

});

module.exports = router;