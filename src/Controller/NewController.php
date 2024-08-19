<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\{TextType, EmailType, PasswordType, ChoiceType, DateType, TextareaType, FileType};
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Entity\{User, Profile, Passport, Documents, Appointment};
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class NewController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    #[IsGranted('ROLE_COACH'),]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        // Create a form builder
        $form = $this->createForm(RegistrationType::class, $user);

        // Handle form submission
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

            return $this->redirectToRoute('app_service');
        }

        return $this->render('new/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
