var request = require('request');
var fs = require('fs');

var targetUrl = 'http://simpel.dephub.go.id/index.php/Dashboard';

request(targetUrl, function (error, response, body) {
	console.log('error: ', error);
	console.log('status code: ', response && response.statusCode);
	fs.writeFileSync('tmp/result.html',body);
});
