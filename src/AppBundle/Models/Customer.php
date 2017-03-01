<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

use Symfony\Component\Security\Core\User\UserInterface;

class Customer implements UserInterface
{
    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $encodedPassword;
    private $passwordSalt;

    public function __construct(string $firstName, string $lastName,
        string $email, string $encodedPassword, string $passwordSalt)
    {
        $this->id = uniqid();
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->encodedPassword = $encodedPassword;
        $this->passwordSalt = $passwordSalt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->encodedPassword;
    }

    public function getSalt()
    {
        return $this->passwordSalt;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials() {}
}
