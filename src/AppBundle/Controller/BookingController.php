<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends Controller
{
    public function bookAction(Request $request)
    {
        $to = $request->get('email');
        $accommodationId = $request->get('accommodationId');

        if ($request->isMethod('POST')) {
            if (!empty($to)) {

                $message = $this->get('app.mailer.message_factory')
                    ->createBookingConfirmationMessage($to, $accommodationId)
                ;
                $this->get('app.mailer')->send($message);

                return new RedirectResponse($this->generateUrl('booking_confirmation'));
            }
            
            $this->addFlash('danger', 'Votre e-mail est invalide');

        return $this->render('@App/Booking/book.html.twig', ['email' => $to]);
    }

    public function bookingConfirmationAction()
    {
        return $this->render('@App/Booking/bookConfirmation.html.twig');
    }
}
