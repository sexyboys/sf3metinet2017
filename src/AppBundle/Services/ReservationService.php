<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

use AppBundle\Models\Reservation;
use AppBundle\Models\ReservationRequest;
use AppBundle\Repositories\ReservationRepository;
use AppBundle\Repositories\ReservationRequestRepository;

class ReservationService
{
    private $reservationRepository;
    private $reservationRequestRepository;
    private $mailer;
    private $messageFactory;

    public function __construct(ReservationRepository $reservationRepository,
        ReservationRequestRepository $reservationRequestRepository,
        Mailer $mailer, MessageFactory $messageFactory)
    {
        $this->reservationRepository = $reservationRepository;
        $this->reservationRequestRepository = $reservationRequestRepository;
        $this->mailer = $mailer;
        $this->messageFactory = $messageFactory;
    }

    public function requestReservation(ReservationRequest $reservationRequest)
    {
        $this->reservationRequestRepository->save($reservationRequest);
    }

    public function acceptRequest(ReservationRequest $reservationRequest)
    {
        $reservationRequest->accept();
        $this->reservationRequestRepository->save($reservationRequest);

        $reservation = Reservation::fromReservationRequest($reservationRequest);
        $this->reservationRepository->save($reservation);

        $message = $this->messageFactory->createBookingConfirmationMessage(
            $reservation->getCustomerEmail(),
            $reservation->getAccommodationId()
        );

        $this->mailer->send($message);
    }

    public function refuseRequest(ReservationRequest $reservationRequest)
    {
        $reservationRequest->refuse();
        $this->reservationRequestRepository->save($reservationRequest);
    }
}
