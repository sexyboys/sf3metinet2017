<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class Reservation
{
    private $id;
    private $accommodationId;
    private $customerEmail;
    private $reservationDate;

    public function __construct($accommodationId, $customerEmail, ReservationDate $reservationDate)
    {
        $this->id = uniqid();
        $this->accommodationId = $accommodationId;
        $this->customerEmail = $customerEmail;
        $this->reservationDate = $reservationDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAccommodationId()
    {
        return $this->accommodationId;
    }

    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    public function getReservationDate(): ReservationDate
    {
        return $this->reservationDate;
    }
}
