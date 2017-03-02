<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

use AppBundle\Models\Customer;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Templating\EngineInterface;

class FakeMailer implements Mailer
{
    private $logger;
    private $templateEngine;

    public function __construct(Logger $logger, EngineInterface $templateEngine)
    {
        $this->logger = $logger;
        $this->templateEngine = $templateEngine;
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

    public function sendResetPasswordToken(Customer $customer, $token)
    {
        $this->logger->debug('Reset Password Token E-mail', [
            'customer' => $customer,
            'token' => $token,
            'clickableUrl' => 'http://127.0.0.1:8000/reset-password/' . $token,
        ]);
    }

    public function sendResetPasswordConfirmation(Customer $customer)
    {
    }
}
