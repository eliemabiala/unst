<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Appointment1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('object')
            ->add('creation_date', null, [
                'widget' => 'single_text',
            ])
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
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',

            ])


           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
