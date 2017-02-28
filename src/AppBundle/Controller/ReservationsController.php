<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ReservationsController extends Controller
{
    public function reserveAction(Request $request)
    {
        $to = $request->get('email');
        $accommodationId = $request->get('accommodationId');

        if ($request->isMethod('POST')) {
            if (!empty($to)) {

                $message = $this->get('app.mailer.message_factory')
                    ->createBookingConfirmationMessage($to, $accommodationId);
                $this->get('app.mailer')->send($message);

                return new RedirectResponse($this->generateUrl('reservation_confirmed'));
            }

            $this->addFlash('danger', 'Votre e-mail est invalide');
        }

        return $this->render('@App/Reservations/reserve.html.twig', ['email' => $to]);
    }

    public function reservationConfirmedAction()
    {
        return $this->render('@App/Reservations/reservationConfirmation.html.twig');
    }
}
