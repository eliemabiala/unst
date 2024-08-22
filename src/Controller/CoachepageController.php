<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CoachepageController extends AbstractController
{
    #[Route('/coachepage', name: 'app_coachepage')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs ou ajuster selon vos besoins
        $users = $userRepository->findAll();

        return $this->render('coachepage/index.html.twig', [
            'users' => $users,
        ]);
    }
}
