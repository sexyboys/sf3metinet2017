<?php

namespace AppBundle\Repositories;

use AppBundle\Models\Accommodation;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class InMemoryAccommodationRepository implements AccommodationRepository
{
    private $accommodations = [];

    public function __construct(array $accommodations)
    {
        $this->accommodations = $accommodations;
    }

    public function save(Accommodation $accommodation)
    {
        $this->accommodations[$accommodation->getId()] = $accommodation;
    }

    public function findAll()
    {
        return $this->accommodations;
    }
}
