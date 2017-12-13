<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://simpel.dephub.go.id'
]);

echo "retrieving data from server ..." . PHP_EOL;
$response = $client->request('GET', '/index.php/Dashboard');

file_put_contents('tmp/php-results.html', $response->getBody());

echo "filterring ..." . PHP_EOL;
$filtered = preg_grep('/^\s+var\s(texx|koordinat|titlee|lng|lat|link|nama)\s=.*/', file('tmp/php-results.html'));
$filtered = array_values(array_filter($filtered));

echo count($filtered) . PHP_EOL;

$sanitized = preg_replace('/^\s+var\s+|;$/', '', $filtered);
// print_r($sanitized);

// Expected data format
// - name
// - description
// - function
// - coordinate:
//   - longitude
//   - latitude
//   - formatted (optional)
// - detail:
//   - url (url to detail resource)
$pelabuhanData = [];

$counter = 0;
$pelabuhanItem = [];
for ($i=0; $i < count($sanitized); $i++) {
    $key = explode(' = ', $sanitized[$i]);
    switch ($key[0]) {
        case 'nama':
            $pelabuhanItem['name'] = $key[1];
            array_push($pelabuhanData, $pelabuhanItem);
            break;

        default:
            # code...
            break;
    }
}
echo $counter . PHP_EOL;

file_put_contents('tmp/pelabuhan-indonesia.json', json_encode($pelabuhanData));

echo "saving filter result ..." . PHP_EOL;
file_put_contents('tmp/php-filtered.js', $sanitized);

echo "done." . PHP_EOL;
