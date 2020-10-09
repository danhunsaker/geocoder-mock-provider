<?php

declare(strict_types=1);

/*
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Danhunsaker\Geocoder\Provider\Mock;

use Geocoder\Collection;
use Geocoder\Location;
use Geocoder\Model\Address;
use Geocoder\Model\AddressBuilder;
use Geocoder\Model\AddressCollection;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use Geocoder\Http\Provider\AbstractHttpProvider;
use Geocoder\Provider\Provider;
use Http\Client\HttpClient;

/**
 * @author Niklas Närhinen <niklas@narhinen.net>
 * @author Jonathan Beliën <jbe@geo6.be>
 */
final class Mock extends AbstractHttpProvider implements Provider
{
    /**
     * @var float[]
     */
    private $latLong;

    /**
     * @var string[]
     */
    private $address;

    /**
     * @param HttpClient $client    an HTTP client
     * @param float[]    $latLong   The latitude and longitude to return for all requests
     * @param string[]   $address   The address to return for all requests
     */
    public function __construct(HttpClient $client, $latLong, $address)
    {
        parent::__construct($client);

        $this->latLong = $latLong;
        $this->address = $address;

        if (empty($this->latLong)) {
            throw new \InvalidArgument('The Lat/Long must be set to use the Mock provider.');
        }

        if (empty($this->address)) {
            throw new \InvalidArgument('The Address must be set to use the Mock provider.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function geocodeQuery(GeocodeQuery $query): Collection
    {
        return new AddressCollection([Address::createFromArray($this->address + [
            'providedBy' => $this->getName(),
            'latitude' => $this->latLong[0],
            'longitude' => $this->latLong[1],
        ])]);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseQuery(ReverseQuery $query): Collection
    {
        return new AddressCollection([Address::createFromArray($this->address + [
            'providedBy' => $this->getName(),
            'latitude' => $this->latLong[0],
            'longitude' => $this->latLong[1],
        ])]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'mock';
    }
}
