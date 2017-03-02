<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Services;

class SimpleTokenGenerator implements TokenGenerator
{
    public function generate()
    {
        return sha1(random_bytes(32));
    }
}
