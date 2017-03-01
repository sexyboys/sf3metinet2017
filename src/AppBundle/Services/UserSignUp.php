<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

use AppBundle\Models\Customer;
use AppBundle\Repositories\CustomerRepository;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use AppBundle\Models\UserSignUp as UserSignUpDto;

class UserSignUp
{
    private $passwordEncoder;
    private $customerRepository;

    public function __construct(PasswordEncoderInterface $passwordEncoder, CustomerRepository $customerRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->customerRepository = $customerRepository;
    }

    public function signUp(UserSignUpDto $signUp)
    {
        $salt = base64_encode(random_bytes(16));
        $encodedPassword = $this->passwordEncoder->encodePassword(
            $signUp->plainTextPassword,
            $salt
        );

        $customer = new Customer(
            $signUp->firstName,
            $signUp->lastName,
            $signUp->email,
            $encodedPassword,
            $salt
        );

        $this->customerRepository->save($customer);
    }
}
