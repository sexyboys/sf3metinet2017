<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccommodationsController extends Controller
{
    public function listAction(Request $request)
    {
        return $this->render('@App/Accommodations/list.html.twig');
    }
}
