<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('subject', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('message', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('termsAccepted', CheckboxType::class, [
                'label' => 'J\'accepte les termes et conditions',
                'required' => true,
                'mapped' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class, // Utilisez votre entité Contact ici
        ]);
    }
}
