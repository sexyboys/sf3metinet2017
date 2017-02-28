<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class ReservationDate
{
    private $from;
    private $to;

    public function __construct(UtcDateTime $from, UtcDateTime $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    public function from(): UtcDateTime
    {
        return $this->from;
    }

    public function to(): UtcDateTime
    {
        return $this->to;
    }
}
