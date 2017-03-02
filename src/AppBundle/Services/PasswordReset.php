<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

use AppBundle\Models\Customer;
use AppBundle\Repositories\CustomerRepository;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use AppBundle\Models\PasswordReset as PasswordResetModel;

class PasswordReset
{
    private $mailer;
    private $tokenGenerator;
    private $passwordEncoder;
    private $customerRepository;

    public function __construct(Mailer $mailer, TokenGenerator $tokenGenerator,
        PasswordEncoderInterface $passwordEncoder, CustomerRepository $customerRepository)
    {
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->passwordEncoder = $passwordEncoder;
        $this->customerRepository = $customerRepository;
    }

    public function requestPasswordReset(Customer $customer)
    {
        $token = $this->tokenGenerator->generate();
        $passwordReset = new PasswordResetModel($token);
        $customer->requestPasswordReset($passwordReset);

        $this->customerRepository->save($customer);

        $this->mailer->sendResetPasswordToken($customer, $token);
    }

    public function resetPassword($token, $newPlainTextPassword)
    {
        $customer = $this->customerRepository->findByPasswordResetToken($token);

        $newEncodedPassword = $this->passwordEncoder->encodePassword(
            $newPlainTextPassword,
            $customer->getSalt()
        );

        $customer->resetPassword($token, $newEncodedPassword);
        $this->customerRepository->save($customer);
    }
}
