<?php

/*
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Danhunsaker\Geocoder\Provider\Mock\Tests;

use Geocoder\IntegrationTest\ProviderIntegrationTest;
use Danhunsaker\Geocoder\Provider\Mock\Mock;
use Http\Client\HttpClient;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class IntegrationTest extends ProviderIntegrationTest
{
    /**
     * @var array with functionName => reason
     */
    protected $skippedTests = [
        'testExceptions' => 'Throwing exceptions is not supported by this provider',
    ];

    protected $testAddress = true;

    protected $testReverse = true;

    protected $testIpv4 = false;

    protected $testIpv6 = false;

    protected function createProvider(HttpClient $httpClient)
    {
        return new Mock($httpClient, [51.5033, -0.1276], ['streetNumber' => '10', 'streetName' => 'Downing St', 'locality' => 'London', 'countryCode' => 'UK']);
    }

    protected function getCacheDir()
    {
        return __DIR__.'/.cached_responses';
    }

    protected function getApiKey()
    {
        return null;
    }
}
