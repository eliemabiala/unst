<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Appointment1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Utilisateur',
                'placeholder' => 'Sélectionnez le mail de l\'utilisateur',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('appointment_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date du rendez-vous',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('appointment_time', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure du rendez-vous',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('object', TextareaType::class, [
                'label' => 'Objet',
                'attr' => [
                    'rows' => 5, // Nombre de lignes dans le textarea
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'objet du rendez-vous',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => function (User $user) {
            //     $name = $user->getProfile() ? $user->getProfile()->getName() : 'No Name';
            //     $postname = $user->getProfile() ? $user->getProfile()->getPostname() : 'No Postname';
            //     return $name . ' ' . $postname;
            // ])
            // }, 