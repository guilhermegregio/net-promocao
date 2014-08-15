var express = require('express');
var router = express.Router();
var Cep = require('../models/anuncios').Cep;
var Ad = require('../models/anuncios').Ad;

router.get('/cadastro-final', function (req, res) {
	var anuncio = new Ad(req.cookies.anuncio);

	console.log(anuncio);
	res.render('cadastro-final', {anuncio: anuncio});
});

module.exports = router;