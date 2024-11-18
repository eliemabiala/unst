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

class NewController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si l'email existe déjà dans la base de données
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if ($existingUser) {
                // Ajouter un message flash pour informer que l'email existe déjà
                $this->addFlash('error', 'Ces information son déjà utilisée.');

                // Rendre à nouveau la vue avec le formulaire et le message flash
                return $this->render('new/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            // Si l'email n'existe pas, continuer avec l'enregistrement de l'utilisateur
            $user->setRoles($form->get('roles')->getData());
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // Envoyer un email de notification
            $email = (new Email())
                ->from('mabialaelie4@gmail.com')
                ->to('endiepro4@gmail.com')
                ->subject('Nouveau utilisateur ajouté')
                ->html(
                    $this->renderView('emails/notification.html.twig', [
                        'user' => $user
                    ])
                );
            $mailer->send($email);

            return $this->redirectToRoute('app_adminpage');
        }

        return $this->render('new/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
