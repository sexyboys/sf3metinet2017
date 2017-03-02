<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class UnableToResetPassword extends \DomainException
{
    public static function noRequestHasBeenMade()
    {
        return new self('Unable to reset password when no reset request has been made');
    }

    public static function tokenMismatch($actualToken, $expectedToken)
    {
        return new self(
            sprintf('Actual token "%s" doesn\'t match expected "%s"', $actualToken, $expectedToken)
        );
    }
}
