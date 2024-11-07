<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Appointment; 
use App\Form\AppointmentType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminpageController extends AbstractController
{
    #[Route('/adminpage', name: 'app_adminpage')]
    // #[IsGranted('ROLE_ADMIN')]
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

        return $this->render('adminpage/index.html.twig', [
            'users' => $users,
            'totalAdmin' => $totalAdmin,
            'totalUser' => $totalUser,
            'totalCoach' => $totalCoach,
        ]);
    }

    #[Route('/adminpage/profile/{id}', name: 'app_user_profile')]
    public function show(User $user): Response
    {
        // Récupérer les rendez-vous associés à cet utilisateur
        $appointments = $user->getAppointments();

        return $this->render('adminpage/profile.html.twig', [
            'user' => $user,
            'appointments' => $appointments,
        ]);
    }

    #[Route('/adminpage/delete/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Sécuriser la suppression avec un token CSRF
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur supprimé avec succès');
        }

        return $this->redirectToRoute('app_adminpage');
    }

    #[Route('/adminpage/appointment/new/{id}', name: 'app_appointment_new')]
    public function createAppointment(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $appointment = new Appointment();
        $appointment->setUser($user); // Associe le rendez-vous à l'utilisateur

        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appointment);
            $entityManager->flush();

            $this->addFlash('success', 'Rendez-vous créé avec succès.');

            return $this->redirectToRoute('app_user_profile', ['id' => $user->getId()]);
        }

        return $this->render('appointment/add_rdv.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
