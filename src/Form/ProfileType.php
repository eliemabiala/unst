<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\User;
use App\Enum\SexeEnum;
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

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('postname', TextType::class, ['label' => 'Post nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
        ->add('genre', ChoiceType::class, [
            'label' => 'Sexe',
            'choices' => [
                'M' => SexeEnum ::Male,
                'F' => SexeEnum ::Female,
                'Autre' => SexeEnum::Other,
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
            ->add('date_inscrit', DateType::class, [
                'label' => 'Date d\'inscription',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('passport', PassportType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
