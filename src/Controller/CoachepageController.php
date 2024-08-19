<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoachepageController extends AbstractController
{
    #[Route('/coachepage', name: 'app_coachepage')]
    public function index(): Response
    {
        return $this->render('coachepage/index.html.twig', [
            'controller_name' => 'CoachepageController',
        ]);
    }
}
