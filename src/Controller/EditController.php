<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EditController extends AbstractController
{
    #[Route('/edit/{id}', name: 'app_edit')]
    #[IsGranted('ROLE_ADMIN')]


    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        int $id
    ): Response {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer les rôles
            $roles = $form->get('roles')->getData();
            $user->setRoles(is_array($roles) ? $roles : [$roles]);

            // Hacher et définir le mot de passe seulement si une nouvelle valeur est fournie
            $newPassword = $form->get('password')->getData();
            if (!empty($newPassword)) {
                $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', [
                'title' => 'Succès',
                'message' => 'L\'utilisateur a été modifié avec succès.'
            ]);


            // Envoi d'un email de notification
            $email = (new Email())
                ->from('mabialaelie4@gmail.com')
                ->to('endiepro4@gmail.com')
                ->subject('Utilisateur modifié')
                ->html(
                    $this->renderView('emails/notificationmodif.html.twig', [
                        'user' => $user
                    ])
                );
            $mailer->send($email);

            return $this->redirectToRoute('app_user_profile', ['id' => $user->getId()]);
        }

        return $this->render('edit/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
