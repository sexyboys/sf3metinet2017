<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

class MessageFactory
{
    private $fromEmail;

    public function __construct(string $fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function createBookingConfirmationMessage($to, $accommodationId)
    {
        return new Message(
            $to,
            $this->fromEmail,
            'Nouvelle demande de réservation',
            sprintf('AccomodationId: #%s', $accommodationId)
        );
    }
}
