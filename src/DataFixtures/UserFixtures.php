<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Teams;
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
            $user->setProfile($profile);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
