<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\Passport;
use App\Enum\SexeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $profile = new Profile();
            $profile->setName('Name' . $i);
            $profile->setPostname('Postname' . $i);
            $profile->setFirstname('Firstname' . $i);
            $profile->setPhone('1234567890');
            $profile->setAddress('Address ' . $i);
            $profile->setGenre(SexeEnum::Female);
            $profile->setDateOfBirth(new \DateTime('2000-01-01'));
            $profile->setDateCreation(new \DateTime());
            $profile->setDateInscrit(new \DateTime());

            // Création du Passport
            $passport = new Passport();
            $passport->setNumberPassport('PassportNumber' . $i);
            $passport->setDateExpiration(new \DateTime('2025-12-31')); // Exemple de date
            $passport->setNationalite('Nationality ' . $i);
            $passport->setProfession('Profession ' . $i);
            $passport->setStatusDemarches('Status ' . $i);

            $manager->persist($passport);

            $profile->setPassport($passport);
            $manager->persist($profile);

            $this->addReference('profile_' . $i, $profile);
        }

        $manager->flush();
    }
}
