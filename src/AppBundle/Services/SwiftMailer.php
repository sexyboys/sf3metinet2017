<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

class SwiftMailer implements Mailer
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Message $message)
    {
        $message = new \Swift_Message($subject, $body);
        $message->addFrom($from);
        $message->addTo($to);

        $this->mailer->send($message);
    }
}
