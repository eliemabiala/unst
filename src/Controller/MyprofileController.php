<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ChangePasswordFormType;

class MyprofileController extends AbstractController
{
    #[Route('/myprofile', name: 'app_myprofile', methods: ['GET'])]
    public function informations(UserInterface $user): Response
    {
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('L\'utilisateur n\'est pas de type User.');
        }

        $profile = $user->getProfile();
        $roles = $user->getRoles();
        $role = !empty($roles) ? $roles[0] : null;

        return $this->render('myprofile/index.html.twig', [
            'firstname' => $profile ? $profile->getFirstname() : null,
            'name' => $profile ? $profile->getName() : null,
            'postname' => $profile ? $profile->getPostname() : null,
            'email' => $user->getEmail(),
            'phone' => $profile ? $profile->getPhone() : null,
            'date_of_birth' => $profile ? $profile->getDateOfBirth() : null,
            'address' => $profile ? $profile->getAddress() : null,
            'role' => $role,
        ]);
    }

    #[Route('/myprofile/edit-password', name: 'app_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(Request $request, UserInterface $user, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('L\'utilisateur n\'est pas de type User.');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été changé avec succès.');

            return $this->redirectToRoute('app_myprofile');
        }

        return $this->render('reset_password/editpassword.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);
    }
}
