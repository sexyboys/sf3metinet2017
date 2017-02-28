<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class ReservationRequest
{
    const ACCEPTED = 'accepted';
    const PENDING = 'pending';
    const REFUSED = 'refused';

    private $accommodationId;
    private $customer;
    private $reservationDate;
    private $status;

    public function __construct($accommodationId, Customer $customer, ReservationDate $reservationDate)
    {
        $this->id = uniqid();
        $this->accommodationId = $accommodationId;
        $this->customer = $customer;
        $this->reservationDate = $reservationDate;
        $this->status = self::PENDING;
    }

    public function accept()
    {
        if (self::PENDING !== $this->status) {

            throw new \DomainException(sprintf(
                'Cannot accept the reservation request, it has already been %s',
                strtolower($this->status)
            ));
        }

        $this->status = self::ACCEPTED;
    }

    public function refuse()
    {
        if (self::PENDING !== $this->status) {

            throw new \DomainException(sprintf(
                'Cannot refuse the reservation request, it has already been %s',
                strtolower($this->status)
            ));
        }

        $this->status = self::REFUSED;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAccommodationId()
    {
        return $this->accommodationId;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getReservationDate(): ReservationDate
    {
        return $this->reservationDate;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
