<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function informations(UserInterface $user): Response
    {
        
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('L\'utilisateur n\'est pas de type User.');
        }

        $profile = $user->getProfile();
        $passport = $profile ? $profile->getPassport() : null; 

        return $this->render('student/index.html.twig', [
            'status_demarches' => $passport ? $passport->getStatusDemarches() : null,
            'firstname' => $profile ? $profile->getFirstname() : null,
            'name' => $profile ? $profile->getName() : null,
            'postname' => $profile ? $profile->getPostname() : null,
            'email' => $user->getEmail(), 
            'phone' => $profile ? $profile->getPhone() : null,
            'date_of_birth' => $profile ? $profile->getDateOfBirth() : null,
            'address' => $profile ? $profile->getAddress() : null,
        ]);
    }
}
