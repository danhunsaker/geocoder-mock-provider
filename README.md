# Mock Geocoder provider
[![Build Status](https://travis-ci.org/danhunsaker/geocoder-mock-provider.svg?branch=main)](http://travis-ci.org/danhunsaker/geocoder-mock-provider)
[![Latest Stable Version](https://poser.pugx.org/danhunsaker/geocoder-mock-provider/v/stable)](https://packagist.org/packages/danhunsaker/geocoder-mock-provider)
[![Total Downloads](https://poser.pugx.org/danhunsaker/geocoder-mock-provider/downloads)](https://packagist.org/packages/danhunsaker/geocoder-mock-provider)
[![Monthly Downloads](https://poser.pugx.org/danhunsaker/geocoder-mock-provider/d/monthly.png)](https://packagist.org/packages/danhunsaker/geocoder-mock-provider)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/danhunsaker/geocoder-mock-provider.svg?style=flat-square)](https://scrutinizer-ci.com/g/danhunsaker/geocoder-mock-provider)
[![Quality Score](https://img.shields.io/scrutinizer/g/danhunsaker/geocoder-mock-provider.svg?style=flat-square)](https://scrutinizer-ci.com/g/danhunsaker/geocoder-mock-provider)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

This is a Mock provider for the PHP Geocoder. This is a **TEST SUPPORT** repository. See the
[main repo](https://github.com/geocoder-php/Geocoder) for information and documentation.

## Install

```bash
composer require danhunsaker/geocoder-mock-provider
```

## Usage

You must supply the values that will be generated as arguments to the constructor :

```php
$provider = new \Danhunsaker\Geocoder\Provider\Mock(
    $httpClient,
    [38.8976633, -77.0365739],
    [
        'streetNumber' => '1600',
        'streetName' => 'Pennsylvania Avenue Northwest',
        'postalCode' => '20500',
        'locality' => 'Washington',
        'adminLevels' => [
            1 => [
                'level' => 1,
                'code' => 'DC',
                'name' => 'District of Columbia',
            ],
        ],
        'country' => 'United States',
        'countryCode' => 'US',
    ]
);
```

**THIS PROVIDER DOES NOT PROVIDE ACTUAL GEOCODING DATA. IT IS MEANT FOR USE WHEN WRITING TESTS _ONLY_.**

## Contribute

Contributions are very welcome! Send a pull request on [this repository](https://github.com/danhunsaker/geocoder-mock-providec) or
report any issues you find on the [issue tracker](https://github.com/danhunsaker/geocoder-mock-providec/issues).
