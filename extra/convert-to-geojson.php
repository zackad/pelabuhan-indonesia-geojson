<?php

$input = json_decode(file_get_contents(__DIR__ . '/peta_pelabuhan.json'), 1);
// print_r($input[0]);

$geoJson = [
    'type' => 'FeatureCollection',
    'features' => [],
];

// print_r($geoJson);
$featureCollection = [];
$feature = [
    'type' => 'Feature',
    'geometry' => [
        'type' => 'Point',
        'coordinates' => [],
    ],
    'properties' => [
        'nama_pelabuhan' => '',
        'nama_kepala_pelabuhan' => '',
        'no_wpp' => '',
        'nama_wpp' => '',
        'kabupaten_kota' => '',
        'status_daerah' => '',
        'provinsi' => '',
        'status_operasional' => '',
        'pengelola_pelabuhan' => '',
        'listrik' => '',
        'air_bersih' => '',
        'tpi' => '',
        'pabrik_es' => '',
        'tangki_bbm' => '',
        'aktif' => '',
        'terintegrasi_pipp' => '',
    ],
];

foreach ($input as $item) {
    $feature['geometry']['coordinates'] = [$item['bujur'], $item['lintang']];
    $feature['properties']['nama_pelabuhan'] = $item['nama_pelabuhan'];
    $feature['properties']['nama_kepala_pelabuhan'] = $item['nama_kepala_pelabuhan'];
    $feature['properties']['no_wpp'] = $item['no_wpp'];
    $feature['properties']['nama_wpp'] = $item['nama_wpp'];
    $feature['properties']['kabupaten_kota'] = $item['kabupaten_kota'];
    $feature['properties']['status_daerah'] = $item['status_daerah'];
    $feature['properties']['provinsi'] = $item['propinsi'];
    $feature['properties']['status_operasional'] = $item['status_operasional'];
    $feature['properties']['pengelola_pelabuhan'] = $item['pengelola_pelabuhan'];
    $feature['properties']['listrik'] = $item['listrik'];
    $feature['properties']['air_bersih'] = $item['air_bersih'];
    $feature['properties']['tpi'] = $item['tpi'];
    $feature['properties']['pabrik_es'] = $item['pabrik_es'];
    $feature['properties']['tangki_bbm'] = $item['tangki_bbm'];
    $feature['properties']['aktif'] = $item['aktif'];
    $feature['properties']['terintegrasi_pipp'] = $item['terintegrasi_pipp'];
    array_push($featureCollection, $feature);
}

$geoJson['features'] = $featureCollection;

file_put_contents('peta_pelabuhan_extra.geojson', json_encode($geoJson, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK));
