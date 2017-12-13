# Pelabuhan Indonesia GeoJSON

Indonesian harbor location data in GeoJSON format. Scrapped from [simpel.dephub.go.id](http://simpel.dephub.go.id/index.php/Dashboard).

## How To Scrapping data

**Requirements:**

- PHP7
- [Guzzle](https://packagist.org/packages/guzzlehttp/guzzle)

Clone this repository

```shell
git clone https://github.com/zackad/pelabuhan-indonesia-geojeon
```

Change to clonned directory and run php script from command line. You may need to create temporary directory to store generated data.

```shell
cd pelabuhan-indonesia-geojeon
mkdir -p tmp
php index.php
```

The generated data will be stored in `tmp` directory as `pelabuhan-indonesia.geojson`. You can rename it to whatever you want by changing this part

```php
...

file_put_contents('tmp/pelabuhan-indonesia.geojson', json_encode($geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));

...
```

## Lisence

The MIT License (MIT)

Copyright (c) 2017 zackad

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
