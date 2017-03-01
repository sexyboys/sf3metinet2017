<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class UserSignUp
{
    private $firstName;
    private $lastName;
    private $email;
    private $plainTextPassword;

    public function __construct($firstName, $lastName, $email, $plainTextPassword)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->plainTextPassword = $plainTextPassword;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPlainTextPassword()
    {
        return $this->plainTextPassword;
    }
}
