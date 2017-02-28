<?php

namespace AppBundle\Controller;

use AppBundle\Models\Reservation;
use AppBundle\Models\ReservationDate;
use AppBundle\Models\UtcDateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ReservationsController extends Controller
{
    public function reserveAction(Request $request)
    {
        $customerEmail = $request->get('email');
        $accommodationId = $request->get('accommodationId');
        $dateFrom = $request->get('from');
        $dateTo = $request->get('to');

        if ($request->isMethod('POST')) {
            if (!empty($customerEmail)) {

                $reservation = new Reservation(
                    $accommodationId,
                    $customerEmail,
                    new ReservationDate(
                        UtcDateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s 00:00:00', $dateFrom)),
                        UtcDateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s 23:59:59', $dateTo))
                    )
                );
                
                $this->get('repositories.reservations')->save($reservation);

                $message = $this->get('app.mailer.message_factory')
                    ->createBookingConfirmationMessage($customerEmail, $accommodationId);
                $this->get('app.mailer')->send($message);

                return new RedirectResponse($this->generateUrl('public.reservation_confirmed'));
            }

            $this->addFlash('danger', 'Votre e-mail est invalide');
        }

        return $this->render('@App/Reservations/reserve.html.twig', [
            'email' => $customerEmail,
            'from' => $dateFrom,
            'to' => $dateTo,
        ]);
    }

    public function reservationConfirmedAction()
    {
        return $this->render('@App/Reservations/reservationConfirmation.html.twig');
    }

    public function listReservationsAction(Request $request)
    {
        $reservations = $this->get('repositories.reservations')->findAll();

        return $this->render(
            '@App/Reservations/reservationsList.html.twig',
            [
                'reservations' => $reservations,
            ]
        );
    }
}
