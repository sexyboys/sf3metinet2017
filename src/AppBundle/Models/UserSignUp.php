<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class UserSignUp
{
    public $firstName;
    public $lastName;
    public $email;
    public $plainTextPassword;

    public function __construct($firstName, $lastName, $email, $plainTextPassword)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->plainTextPassword = $plainTextPassword;
    }
}
