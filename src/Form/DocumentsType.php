<?php

namespace App\Form;

use App\Entity\Documents;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DocumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('file_path', VichFileType::class, [
            'label' => 'Document',
            'required' => true,
        ])
            ->add('coach', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Sélectionner un destinataire', 
                'choices' => $options['users'], 
                'placeholder' => 'Choisissez un destinataire',
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Documents::class,
            'users' => [] // Ajout de la variable 'users' pour les passer depuis le contrôleur
        ]);
    }
}
