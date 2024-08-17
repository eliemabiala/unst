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
use Doctrine\ORM\EntityManagerInterface;

class NewController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    public function index(Request $request, FormFactoryInterface $formFactory, ParameterBagInterface $params, EntityManagerInterface $entityManager): Response
    {
        // Create a form builder
        $form = $formFactory->createBuilder()
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('role', ChoiceType::class, [
                'label' => 'Choisissez un rôle',
                'choices' => [
                    'Administrateur' => 'admin',
                    'Coach' => 'coach',
                    'Utilisateur' => 'user',
                ],
                'placeholder' => '-- Sélectionnez un rôle --',
            ])
            ->add('teams', TextType::class, ['label' => 'Teams'])
            ->add('password', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('postname', TextType::class, ['label' => 'Post nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'M' => 'M',
                    'F' => 'F',
                    'Autres' => 'Autres',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('phone', TextType::class, ['label' => 'Téléphone'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('date_of_birth', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('date_creation', DateType::class, [
                'label' => 'Date de création dossier',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('date_inscrit', DateType::class, [
                'label' => 'Date d\'inscription',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('number_passport', TextType::class, ['label' => 'Numéro de passeport'])
            ->add('date_expiration', DateType::class, [
                'label' => 'Date d\'expiration',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('nationalite', TextType::class, ['label' => 'Nationalité'])
            ->add('profession', TextType::class, ['label' => 'Profession'])
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('file_upload', FileType::class, [
                'label' => 'Choisissez un fichier',
                'required' => false,
            ])
            ->add('download_date', DateType::class, [
                'label' => 'Date de téléchargement',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ])
            ->add('date_update', DateType::class, [
                'label' => 'Date de mise à jour',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('object', TextType::class, ['label' => 'Objet'])
            ->add('Creation_Date', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->getForm();

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the data
            $data = $form->getData();

            // Handle file upload
            $file = $form->get('file_upload')->getData();
            if ($file) {
                $newFilename = uniqid() . '.' . $file->guessExtension();
                $file->move($params->get('uploads_directory'), $newFilename);
                $documents = new Documents();
                $documents->setFileName($newFilename);
                $documents->setFilePath($params->get('uploads_directory') . '/' . $newFilename);
            }

            // Create and populate entities
            $user = new User();
            $user->setEmail($data['email']);
            $user->setRole($data['role']);
            $user->setTeams($data['teams']);
            $user->setPassword($data['password']);

            $profile = new Profile();
            $profile->setName($data['name']);
            $profile->setPostname($data['postname']);
            $profile->setFirstname($data['firstname']);
            $profile->setSexe($data['sexe']);
            $profile->setPhone($data['phone']);
            $profile->setAddress($data['address']);
            $profile->setDateOfBirth($data['date_of_birth']);
            $profile->setDateCreation($data['date_creation']);
            $profile->setDateInscrit($data['date_inscrit']);

            $passport = new Passport();
            $passport->setNumberPassport($data['number_passport']);
            $passport->setDateExpiration($data['date_expiration']);
            $passport->setNationalite($data['nationalite']);
            $passport->setProfession($data['profession']);

            $appointment = new Appointment();
            $appointment->setDateUpdate($data['date_update']);
            $appointment->setObject($data['object']);
            $appointment->setCreationDate($data['Creation_Date']);

            if (isset($data['download_date'])) {
                $documents->setDownloadDate($data['download_date']);
            }

            // Persist entities
            $entityManager->persist($user);
            $entityManager->persist($profile);
            $entityManager->persist($passport);
            if (isset($documents)) {
                $entityManager->persist($documents);
            }
            $entityManager->persist($appointment);
            $entityManager->flush();

            return $this->redirectToRoute('app_service');
        }

        return $this->render('new/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
