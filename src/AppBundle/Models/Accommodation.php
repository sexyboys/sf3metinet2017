<?php

namespace AppBundle\Models;

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

    public function __construct(int $pricePerNight, int $flatSize, string $location,
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

    public function getPricePerNight()
    {
        return $this->pricePerNight;
    }

    public function getFlatSize()
    {
        return $this->flatSize;
    }

    public function getLocation()
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
