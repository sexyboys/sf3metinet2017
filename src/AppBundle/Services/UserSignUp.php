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
            $signUp->getPlainTextPassword(),
            $salt
        );

        $customer = new Customer(
            $signUp->getFirstName(),
            $signUp->getLastName(),
            $signUp->getEmail(),
            $encodedPassword,
            $salt
        );

        $this->customerRepository->save($customer);
    }
}
