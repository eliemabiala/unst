<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachepageController extends AbstractController
{
    #[Route('/coachepage', name: 'app_coachepage')]
    public function index(UserRepository $userRepository): Response
    {
        // Get the logged-in user
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        // Get the user's team using getTeams()
        $team = $currentUser->getTeams();

        if (!$team) {
            throw $this->createAccessDeniedException('Vous n\'avez pas d\'équipe assignée.');
        }

        // Find all users belonging to the same team
        $users = $userRepository->findBy(['teams' => $team]);

        // Count users with 'ROLE_USER'
        $totalUser = 0;
        foreach ($users as $user) {
            if (in_array('ROLE_USER', $user->getRoles())) {
                $totalUser++;
            }
        }

        return $this->render('coachepage/index.html.twig', [
            'users' => $users,
            'totalUser' => $totalUser,
        ]);
    }

    #[Route('/coachepage/profile/{id}', name: 'app_coach_profile')]
    public function show(User $user): Response
    {
        return $this->render('coachepage/profile.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/coachepage/appointments', name: 'app_coachepage_appointments')]
    public function appointments(AppointmentRepository $appointmentRepository): Response
    {
        // Get the currently logged-in user
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        // Retrieve the appointments for the current user from the repository
        $appointments = $appointmentRepository->findBy(['user' => $currentUser]);

        // Pass the 'appointments' to the Twig template
        return $this->render('coachepage/appointmentss.html.twig', [
            'appointments' => $appointments,  // Passing the variable to Twig
        ]);
    }

}
