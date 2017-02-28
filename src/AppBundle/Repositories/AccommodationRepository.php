<?php

namespace AppBundle\Repositories;

use AppBundle\Models\Accommodation;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

interface AccommodationRepository
{
    public function save(Accommodation $accommodation);
    public function findAll();
}
