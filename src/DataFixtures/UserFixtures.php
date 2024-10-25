<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Teams;
use App\Entity\Documents;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\File\File;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $teamsRepo = $manager->getRepository(Teams::class);
        $teams = $teamsRepo->findAll();

        if (empty($teams)) {
            throw new \RuntimeException('No teams found. Please load teams fixtures first.');
        }

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail('mail' . $i . '@gmail.com');

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'password' . $i
            );

            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_STUDENT']);
            $user->setTeams($teams[array_rand($teams)]);

            // Associez un profil à l'utilisateur
            $profile = $this->getReference('profile_' . $i);
            if ($profile) {
                $user->setProfile($profile);
            } else {
                throw new \RuntimeException('Profile reference not found for user with index ' . $i);
            }

            // Créez et associez des documents à l'utilisateur
            for ($j = 1; $j <= 3; $j++) {
                $document = new Documents();
                $document->setFileName('Document ' . $j . ' for user ' . $i);

                // Créez un fichier temporaire pour simuler un fichier téléchargé
                $tempFile = tempnam(sys_get_temp_dir(), 'upload_');
                file_put_contents($tempFile, 'This is the content of the file ' . $j);

                $file = new File($tempFile); // Créez un objet File

                $document->setFilePath($file); // Associez l'objet File au document
                $document->setUser($user); // Utilisez setUser au lieu de addUser
                $manager->persist($document);
            }

            $manager->persist($user);
        }

        $manager->flush();

        // Nettoyez les fichiers temporaires
        foreach (glob(sys_get_temp_dir() . '/upload_*') as $file) {
            unlink($file);
        }
    }
}
