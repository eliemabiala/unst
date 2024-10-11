<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\User; // Ajoutez l'import de la classe User
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Ajoutez l'import du type EntityType
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Appointment1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('object')
            ->add('appointment_date', DateType::class, [
                'widget' => 'single_text',  // Champ pour la date du rendez-vous
            ])
            ->add('appointment_time', TimeType::class, [  // Champ pour l'heure du rendez-vous
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [  // Utilisez EntityType correctement ici
                'class' => User::class,         // Spécifiez la classe User pour ce champ
                'choice_label' => 'email',      // Affichez l'email comme libellé des choix
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