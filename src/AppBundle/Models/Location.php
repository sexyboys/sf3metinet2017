<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class Location
{
    private $streetNumber;
    private $street;
    private $locality;
    private $postalCode;
    private $country;

    public function __construct(string $streetNumber,string $street, string $postalCode, string $locality, string $country)
    {
        $this->streetNumber = $streetNumber;
        $this->street = $street;
        $this->locality = $locality;
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getLocality()
    {
        return $this->locality;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function __toString()
    {
        $addressFormat =<<<ADDRESS
%s, %s
%s, %s
%s
ADDRESS;
        return sprintf(
            $addressFormat,
            $this->streetNumber,
            $this->street,
            $this->postalCode,
            $this->locality,
            strtoupper($this->country)
        );

    }
}
