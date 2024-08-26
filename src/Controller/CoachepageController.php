<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachepageController extends AbstractController
{
    #[Route('/coachepage', name: 'app_coachepage')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        // Initialize counters
        $totalAdmin = 0;
        $totalUser = 0;
        $totalCoach = 0;

        // Count users by role
        foreach ($users as $user) {
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                $totalAdmin++;
            }
            if (in_array('ROLE_USER', $user->getRoles())) {
                $totalUser++;
            }
            if (in_array('ROLE_COACH', $user->getRoles())) {
                $totalCoach++;
            }
        }

        return $this->render('coachepage/index.html.twig', [
            'users' => $users,
            'totalAdmin' => $totalAdmin,
            'totalUser' => $totalUser,
            'totalCoach' => $totalCoach,
        ]);
    }

    #[Route('/coachepage/profile/{id}', name: 'app_user_profile')]
    public function show(User $user): Response
    {
        return $this->render('coachepage/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
