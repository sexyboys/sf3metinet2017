<?php

namespace AppBundle\Services;

use AppBundle\Models\Customer;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
interface Mailer
{
    public function send(Message $message);

    public function sendResetPasswordToken(Customer $customer, $token);
    public function sendResetPasswordConfirmation(Customer $customer);
}
