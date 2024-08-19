<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                    'Utilisateur' => 'ROLE_USER',
                ],
                'placeholder' => '-- Sélectionnez un rôle --',
            ])
            ->add('teams', TextType::class, ['label' => 'Teams'])
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
