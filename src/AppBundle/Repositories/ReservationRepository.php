<?php

namespace AppBundle\Repositories;

use AppBundle\Models\Reservation;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

interface ReservationRepository
{
    public function save(Reservation $reservation);
    public function findAll();
}
