var request = require('request');
var fs = require('fs');
var LineFilter = require('node-line-reader').LineFilter;

var targetUrl = 'http://simpel.dephub.go.id/index.php/Dashboard';
var filter = new LineFilter({
	skipEmpty: true,
	include: /^\s+var\s(texx|koordinat|titlee|lng|lat|link|nama)\s=.*/
});

request(targetUrl, function (error, response, body) {
	console.log('error: ', error);
	console.log('status code: ', response && response.statusCode);
	if (!error && response.statusCode === 200) {
		fs.writeFileSync('tmp/result.html', body);
	}
});

// var stream = fs.createReadStream('tmp/result.html');
// var filteredResults = stream.pipe(filter);
// fs.writeFileSync('tmp/filtered.js');
