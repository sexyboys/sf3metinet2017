<?php

namespace AppBundle\Controller;

use AppBundle\Models\Customer;
use AppBundle\Models\ReservationDate;
use AppBundle\Models\ReservationRequest;
use AppBundle\Models\UtcDateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ReservationsController extends Controller
{
    public function reserveAction(Request $request)
    {
        /** @var Customer $customer */
        $customer = $this->getUser();
        $accommodationId = $request->get('accommodationId');
        $dateFrom = $request->get('from');
        $dateTo = $request->get('to');

        if ($request->isMethod('POST')) {
            $reservationRequest = new ReservationRequest(
                $accommodationId,
                $customer,
                new ReservationDate(
                    UtcDateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s 00:00:00', $dateFrom)),
                    UtcDateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s 23:59:59', $dateTo))
                )
            );

            $this->get('reservations')->requestReservation($reservationRequest);

            return new RedirectResponse($this->generateUrl('public.reservation_confirmed'));
        }

        return $this->render('@App/Reservations/reserve.html.twig', [
            'from' => $dateFrom,
            'to' => $dateTo,
        ]);
    }

    public function reservationConfirmedAction()
    {
        return $this->render('@App/Reservations/reservationConfirmation.html.twig');
    }

    public function listReservationRequestsAction(Request $request)
    {
        $reservationRequests = $this->get('repositories.reservation_requests')->findAll();

        return $this->render(
            '@App/Reservations/reservationRequestsList.html.twig',
            [
                'reservationRequests' => $reservationRequests,
            ]
        );
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

    public function acceptReservationRequestAction(Request $request)
    {
        $reservationRequest = $this->get('repositories.reservation_requests')
            ->findById($request->get('reservationRequestId'))
        ;

        $this->get('reservations')->acceptRequest($reservationRequest);

        $this->addFlash(
            'info',
            sprintf('La demande de réservation #%s a bien été acceptée', $reservationRequest->getId())
        );

        return new RedirectResponse($this->generateUrl('admin.reservation_requests'));
    }

    public function refuseReservationRequestAction(Request $request)
    {
        $reservationRequest = $this->get('repositories.reservation_requests')
            ->findById($request->get('reservationRequestId'))
        ;
        $this->get('reservations')->refuseRequest($reservationRequest);

        $this->addFlash(
            'info',
            sprintf('La demande de réservation #%s a bien été refusée', $reservationRequest->getId())
        );

        return new RedirectResponse($this->generateUrl('admin.reservation_requests'));
    }
}
