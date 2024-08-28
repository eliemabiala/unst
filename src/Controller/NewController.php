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
            $user->setRoles([$form->get('roles')->getData()]);
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // // Handle file upload
            // $file = $form->get('file_upload')->getData();
            // if ($file) {
            //     $newFilename = uniqid() . '.' . $file->guessExtension();
            //     $file->move($params->get('uploads_directory'), $newFilename);
            //     $documents = new Documents();
            //     $documents->setFileName($newFilename);
            //     $documents->setFilePath($params->get('uploads_directory') . '/' . $newFilename);
            // }

            $entityManager->persist($user);
            $entityManager->flush();

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
