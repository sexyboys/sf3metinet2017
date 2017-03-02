<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

use AppBundle\Models\Customer;
use AppBundle\Models\Host;
use AppBundle\Models\HostSignUp;
use AppBundle\Repositories\CustomerRepository;
use AppBundle\Repositories\HostRepository;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use AppBundle\Models\CustomerSignUp;

class UserSignUp
{
    private $passwordEncoder;
    private $customerRepository;
    private $hostRepository;

    public function __construct(PasswordEncoderInterface $passwordEncoder,
        CustomerRepository $customerRepository, HostRepository $hostRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->customerRepository = $customerRepository;
        $this->hostRepository = $hostRepository;
    }

    public function signUpCustomer(CustomerSignUp $signUp)
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

    public function signUpHost(HostSignUp $signUp)
    {
        $salt = base64_encode(random_bytes(16));
        $encodedPassword = $this->passwordEncoder->encodePassword(
            $signUp->plainTextPassword,
            $salt
        );

        $host = new Host(
            $signUp->firstName,
            $signUp->lastName,
            $signUp->email,
            $signUp->phoneNumber,
            $encodedPassword,
            $salt
        );

        $this->hostRepository->save($host);
    }
}
