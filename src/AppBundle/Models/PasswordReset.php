<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class PasswordReset
{
    private $token;
    private $requestedOn;

    public function __construct($token)
    {
        $this->token = $token;
        $this->requestedOn = (new UtcDateTime('now'))->getDateTimeImmutable();
    }

    public function getToken()
    {
        return $this->token;
    }

    public function tokenEquals($token)
    {
        return $this->token === $token;
    }

    public function getRequestedOn(): \DateTimeImmutable
    {
        return $this->requestedOn;
    }
}
