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
                'allow_delete' => false,
                'download_uri' => true, // Afficher le lien de téléchargement si le fichier existe déjà
            ])
            ->add('coach', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => false,
                'choices' => $options['users'],
                'placeholder' => 'Choisissez un destinataire',
                'required' => false, // Permet de ne pas sélectionner de coach si ce n'est pas obligatoire
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Documents::class,
            'users' => [], // Ajout de la variable 'users' pour être passée depuis le contrôleur
        ]);
    }
}
