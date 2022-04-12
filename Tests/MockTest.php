<?php

namespace Danhunsaker\Geocoder\Provider\Mock\Tests;

use Danhunsaker\Geocoder\Provider\Mock\Mock;
use Geocoder\Exception\InvalidArgument;
use Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;

class MockTest extends TestCase
{
    public function testInstantiation()
    {
        $mock = new Mock(
            $this->createMock(HttpClient::class),
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

        $this->assertInstanceOf(Mock::class, $mock);
    }

    public function testInstantiationWithEmptyCoordinates()
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The Lat/Long must be set to use the Mock provider.');

        $mock = new Mock(
            $this->createMock(HttpClient::class),
            [],
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

        $this->assertInstanceOf(Mock::class, $mock);
    }

    public function testInstantiationWithEmptyAddress()
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The Address must be set to use the Mock provider.');

        $mock = new Mock(
            $this->createMock(HttpClient::class),
            [38.8976633, -77.0365739],
            []
        );

        $this->assertInstanceOf(Mock::class, $mock);
    }
}
