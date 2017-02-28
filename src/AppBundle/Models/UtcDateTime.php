<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

use DateTimeZone;

class UtcDateTime
{
    private $datetime;

    public function __construct($time = "now")
    {
        $this->datetime = new \DateTimeImmutable($time, new \DateTimeZone('UTC'));
    }

    public static function createFromFormat($format, $time)
    {
        $d = \DateTimeImmutable::createFromFormat($format, $time, new \DateTimeZone('UTC'));

        return new self($d->format(\DateTime::ATOM));
    }

    public function getDateTimeImmutable()
    {
        return $this->datetime;
    }
}
