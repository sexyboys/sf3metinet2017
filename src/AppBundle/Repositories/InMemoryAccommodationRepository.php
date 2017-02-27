<?php

namespace AppBundle\Repositories;

use AppBundle\Models\Accommodation;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class InMemoryAccommodationRepository implements AccommodationRepository
{
    private $accommodations = [];

    public function __construct()
    {
        $this->accommodations =             [
            new Accommodation(
                8000,
                50,
                'rue de Chabrol, 75010, Paris',
                'En plein coeur de Paris !',
                'http://www.parisrues.com/imagesold/10/101ruedechabrol02.jpg'
            ),
            new Accommodation(
                5000,
                24,
                'rue Saint-Maur, 75011, Paris',
                'Un quartier très calme, à deux pas d\'Oberkampf',
                'http://www.parisrues.com/imagesold/10/101ruesaintmaur04.jpg'
            ),
        ];
    }

    public function findAll()
    {
        return $this->accommodations;
    }
}
