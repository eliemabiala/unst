<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/terms-conditions', name: 'terms_conditions')]
    public function show(): Response
    {
        return $this->render('terms/conditions.html.twig', [
            'controller_name' => 'TermsController',
        ]);
    }
    
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        // Création d'un nouvel objet Contact
        $contact = new Contact();

        // Création du formulaire de contact
        $form = $this->createForm(ContactType::class, $contact);

        // Traitement de la requête
        $form->handleRequest($request);

        // Vérification si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde du contact en base de données
            $entityManager->persist($contact);
            $entityManager->flush();

            // Création de l'email
            $email = (new Email())
                ->from($this->getParameter('mailer_from')) // Utilise l'adresse email définie dans .env
                ->to($this->getParameter('mailer_to')) // Utilise l'adresse email définie dans .env
                ->subject('Nouveau message reçu')
                ->text('Vous avez un nouveau message.')
                ->html($this->renderView('emails/notificationcontact.html.twig',
                    [
                        'contact' => $contact,
                    ]
                ));

            // Envoi de l'email
            $mailer->send($email);


            // Envoi de l'email
            $mailer->send($email);

            // Ajout d'un message flash de succès
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            // Redirection vers la même page (ou une autre page si nécessaire)
            return $this->redirectToRoute('app_contact');
        }

        // Rendu du formulaire dans le template
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
