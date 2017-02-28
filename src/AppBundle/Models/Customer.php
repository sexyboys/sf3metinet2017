<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class Customer
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
