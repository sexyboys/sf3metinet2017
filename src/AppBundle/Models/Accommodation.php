<?php

namespace AppBundle\Models;

use Money\Money;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class Accommodation
{
    private $id;
    private $pricePerNight;
    private $flatSize;
    private $location;
    private $description;
    private $photoUrl;

    public function __construct(Money $pricePerNight, FlatSize $flatSize, Location $location,
        string $description, string $photoUrl)
    {
        $this->id = uniqid();
        $this->pricePerNight = $pricePerNight;
        $this->flatSize = $flatSize;
        $this->location = $location;
        $this->description = $description;
        $this->photoUrl = $photoUrl;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPricePerNight(): Money
    {
        return $this->pricePerNight;
    }

    public function getFlatSize(): FlatSize
    {
        return $this->flatSize;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }
}
