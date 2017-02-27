<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccommodationsController extends Controller
{
    public function listAction(Request $request)
    {
        $accommodationRepository = $this->get('repositories.accommodations');
        $accommodations = $accommodationRepository->findAll();

        return $this->render('@App/Accommodations/list.html.twig', [
            'accommodations' => $accommodations,
        ]);
    }
}
