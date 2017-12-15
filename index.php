<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://simpel.dephub.go.id'
]);

echo "retrieving data from server ..." . PHP_EOL;
$response = $client->request('GET', '/index.php/Dashboard');

// create temporary directory if not exists
if (!is_dir('tmp')) {
    mkdir('tmp', 0755, true);
}

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
// - category
// - coordinate:
//   - longitude
//   - latitude
//   - formatted (optional)
// - detail:
//   - url (url to detail resource)
$pelabuhanData = [];

$geojson = [
    'type' => 'FeatureCollection',
    'features' => [],
];

$featureCollection = [];

$feature = [
    'type' => 'Feature',
    'geometry' => [
        'type' => 'Point',
        'coordinates' => [],
    ],
    'properties' => [
        'name' => '',
        'description' => '',
        'category' => '',
        'detail' => [
            'url' => '',
        ],
    ]
];

$counter = 0;
$pelabuhanItem = [
    'name' => '',
    'description' => '',
    'category' => '',
    'coordinate' => [
        'longitude' => '',
        'latitude' => '',
        'formatted' => '',
    ],
    'detail' => [
        'url' => '',
    ],
];
for ($i=0; $i < count($sanitized); $i++) {
    $text = explode(' = ', $sanitized[$i]);
    $key = $text[0];
    $value = normalizeString($text[1]);
    switch ($key) {
        case 'nama':
            $namaPelabuhan = $value;
            $namaPelabuhan = preg_replace('/^PT\.?\s?/', 'PT. ', $namaPelabuhan);
            $namaPelabuhan = preg_replace('/\s+/', ' ', $namaPelabuhan);
            $pelabuhanItem['name'] = $namaPelabuhan;

            $feature['properties']['name'] = $namaPelabuhan;

            array_push($pelabuhanData, $pelabuhanItem);
            array_push($featureCollection, $feature);
            break;
        case 'texx':
            $pelabuhanItem['description'] = $value;
            $feature['properties']['description'] = $value;
            break;
        case 'titlee':
            $pelabuhanItem['category'] = $value;
            $feature['properties']['category'] = $value;
            break;
        case 'lng':
            $value = normalizeLongitude($value);
            $pelabuhanItem['coordinate']['longitude'] = $value;
            $feature['geometry']['coordinates'][0] = $value;
            break;
        case 'lat':
            $pelabuhanItem['coordinate']['latitude'] = $value;
            $feature['geometry']['coordinates'][1] = $value;
            break;
        case 'koordinat':
            $pelabuhanItem['coordinate']['formatted'] = $value;
            break;
        case 'link':
            $pelabuhanItem['detail']['url'] = $value;
            $feature['properties']['detail']['url'] = $value;
            break;
        default:
            # code...
            break;
    }
}
echo $counter . PHP_EOL;

file_put_contents('tmp/pelabuhan-indonesia.json', json_encode($pelabuhanData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));

$geojson['features'] = $featureCollection;
file_put_contents('tmp/pelabuhan-indonesia.geojson', json_encode($geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));

echo "saving filter result ..." . PHP_EOL;
file_put_contents('tmp/php-filtered.js', $sanitized);

echo "done." . PHP_EOL;

/**
 * Remove unnecessary character from string
 */
function normalizeString(string $text)
{
    $text = preg_replace('/\n|^\'|\'$|^\"|\"$/', '', $text);
    $text = preg_replace('/\s+/', ' ', $text);
    return $text;
}

/**
 * Normalize longitude coordinate value
 * -180 < longitude < 180
 */
function normalizeLongitude($longitude)
{
    if ($longitude > 360) {
        $longitude = $longitude % 360;
    }

    if ($longitude > 180) {
        $longitude = 0 - ($longitude % 180);
    }

    if ($longitude < -180) {
        $longitude = 180 + ($longitude % 180);
    }
    return $longitude;
}
