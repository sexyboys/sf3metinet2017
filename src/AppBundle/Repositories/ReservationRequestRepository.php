<?php

namespace AppBundle\Repositories;

use AppBundle\Models\ReservationRequest;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

interface ReservationRequestRepository
{
    public function save(ReservationRequest $reservationRequest);
    public function findAll();
    public function findById(string $reservationRequestId);
}
