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

router.get('/', function () {
	res.json({status: 'ok'});
});

router.post('/', function (req, res) {
	var anuncio = new Ad(req.body);

	//	anuncio.save();

	if (anuncio.get('cliente-net') === 'sim') {
		res.redirect('/conversao-cliente.html');
	} else {
		res.redirect('/cadastro-final.html');
	}
});

router.post('/cadastro', function (req, res) {
	var anuncio = new Ad(req.body);

	//	anuncio.save();

	var atende = Cep.findOne({CEP: Number(anuncio.get('cep'))}, 'CEP CIDADE', function (err, cep) {
		if (err) res.json(err);
		if (cep !== null) {
			res.redirect('/conversao-nao-cliente.html');
		} else {
			res.redirect('/nao-atende.html');
		}
	});

});

module.exports = router;