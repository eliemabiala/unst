<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Teams;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('roles', ChoiceType::class, [
                'label' => 'Choisissez un rôle',
                'mapped' => false,
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Coach' => 'ROLE_COACH',
                    'Etudiant' => 'ROLE_STUDENT',
                ],
                'placeholder' => '-- Sélectionnez un rôle --',
            ])
            ->add('teams', EntityType::class, [
                'class' => Teams::class,
                'choice_label' => 'team',
                'label' => 'Team',
                'placeholder' => '-- Sélectionnez une équipe --',
            ])
            ->add('password', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('profile', ProfileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
