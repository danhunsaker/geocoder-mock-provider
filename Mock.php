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
        $builder = new AddressBuilder($this->getName());

        foreach (['state', 'county'] as $i => $tagName) {
            if (\array_key_exists($tagName, $this->address)) {
                $builder->addAdminLevel($i + 1, $this->address[$tagName], '');
            }
        }

        foreach (['zip', 'postalCode', 'code'] as $postalCodeField) {
            if (array_key_exists($postalCodeField, $this->address)) {
                $postalCodeFieldContent = $this->address[$postalCodeField];

                if (!empty($postalCodeFieldContent)) {
                    $builder->setPostalCode($postalCodeFieldContent);

                    break;
                }
            }
        }

        foreach (['city', 'town', 'village', 'hamlet'] as $localityField) {
            if (array_key_exists($localityField, $this->address)) {
                $localityFieldContent = $this->address[$localityField];

                if (!empty($localityFieldContent)) {
                    $builder->setLocality($localityFieldContent);

                    break;
                }
            }
        }

        $builder->setStreetNumber($this->address['number'] ?? null);
        $builder->setStreetName($this->address['street'] ?? $this->address['road'] ?? null);
        $builder->setSubLocality($this->address['suburb'] ?? null);
        $builder->setCountry($this->address['country'] ?? null);
        $builder->setCountryCode(isset($this->address['country_code']) ? strtoupper($this->address['country_code']) : null);

        // Required by the integration tests
        $builder->setCoordinates(floatval($this->latLong[0]), floatval($this->latLong[1]));

        return new AddressCollection([$builder->build(Address::class)]);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseQuery(ReverseQuery $query): Collection
    {
        $builder = new AddressBuilder($this->getName());

        $builder->setCoordinates(floatval($this->latLong[0]), floatval($this->latLong[1]));

        return new AddressCollection([$builder->build(Address::class)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'mock';
    }
}
