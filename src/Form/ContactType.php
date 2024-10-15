<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Email',
            ])
            ->add('subject', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Sujet',
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Message',
            ])
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false, // Ce champ ne sera pas enregistré dans la base de données
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos termes et conditions pour continuer.',
                    ]),
                ],
                'label' => 'J\'accepte les termes et conditions',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
