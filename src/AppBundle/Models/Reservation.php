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

    public static function fromReservationRequest(ReservationRequest $reservationRequest)
    {
        if (ReservationRequest::ACCEPTED !== $reservationRequest->getStatus()) {

            throw new \DomainException(sprintf(
                'Cannot create a Reservation which has not been accepted yet, Reservation Request #%s',
                $reservationRequest->getId()
            ));
        }

        return new self(
            $reservationRequest->getAccommodationId(),
            $reservationRequest->getCustomer(),
            $reservationRequest->getReservationDate()
        );
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

    private function __construct($accommodationId, Customer $customer, ReservationDate $reservationDate)
    {
        $this->id = uniqid();
        $this->accommodationId = $accommodationId;
        $this->customer = $customer;
        $this->reservationDate = $reservationDate;
    }
}
