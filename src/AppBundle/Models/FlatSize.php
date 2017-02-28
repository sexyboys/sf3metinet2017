<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Models;

class FlatSize
{
    private $area;

    public static function inSquareMeter(float $area)
    {
        return new self($area);
    }

    private function __construct(float $area)
    {
        $this->area = $area;
    }

    public function getArea()
    {
        return $this->area;
    }
    
    public function __toString()
    {
        return sprintf('%sm²', $this->area);
    }
}
