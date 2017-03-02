<?php

namespace AppBundle\Repositories;

use AppBundle\Models\Host;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

interface HostRepository
{
    public function save(Host $customer);
    public function findById($id);
}
