<?php

namespace AppBundle\Services;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
interface Mailer
{
    public function send(Message $message);
}
