var mongoose = require('mongoose'),
	single_connection;

module.exports = function () {

	if (!single_connection) {
		single_connection = mongoose.connect('mongodb://localhost/netPromocao');
	}

	return single_connection;
};