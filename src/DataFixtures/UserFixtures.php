<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Teams;
use App\Entity\Documents;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
            $user->setRoles(['ROLE_USER']);
            $user->setTeams($teams[array_rand($teams)]);

            // Associez un profil à l'utilisateur
            $profile = $this->getReference('profile_' . $i);
            if ($profile) {
                $user->setProfile($profile);
            } else {
                throw new \RuntimeException('Profile reference not found for user with index ' . $i);
            }

            // Créez est associez des documents à l'utilisateur
            for ($j = 1; $j <= 3; $j++) {
                $document = new Documents();
                $document->setFileName('Document ' . $j . ' for user ' . $i); 
                $document->setFilePath('/path/to/document_' . $j . '_user_' . $i . '.txt'); //un chemin de fichier
                $document->addUser($user); // Associez l'utilisateur au document
                $manager->persist($document);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
