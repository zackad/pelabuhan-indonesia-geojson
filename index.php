<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://simpel.dephub.go.id'
]);

echo "retrieving data from server ...";
$response = $client->request('GET', '/index.php/Dashboard');

file_put_contents('tmp/php-results.html', $response->getBody());
