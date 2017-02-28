<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

use Psr\Log\LoggerInterface as Logger;

class FakeMailer implements Mailer
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function send(Message $message)
    {
        $this->logger->debug('Booking requested', [
            'to' => $message->getTo(),
            'from' => $message->getFrom(),
            'subject' => $message->getSubject(),
            'body' => $message->getBody(),
        ]);
    }
}
