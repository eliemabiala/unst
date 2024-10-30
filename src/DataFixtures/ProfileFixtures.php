<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\Passport;
use App\Enum\SexeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProfileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Listes de noms et prénoms congolais
        $nomCongolais = ['Mbemba', 'Mutombo', 'Kabila', 'Lutumba', 'Nzinga', 'Lukusa', 'Mokonzi', 'Tshibanda', 'Kakoma', 'Bokamba'];
        $prenomMasculinCongolais = ['Jean', 'Patrice', 'Christian', 'Joseph', 'Michel', 'François', 'Emmanuel', 'Alain', 'Paul', 'Thierry'];
        $prenomFemininCongolais = ['Marie', 'Christine', 'Jacqueline', 'Therese', 'Josephine', 'Claudine', 'Juliette', 'Monique', 'Suzanne', 'Pauline'];

        for ($i = 1; $i <= 10; $i++) {
            $profile = new Profile();

            // Alterne entre homme et femme
            $isMale = $i % 2 === 0;
            $profile->setGenre($isMale ? SexeEnum::Male : SexeEnum::Female);

            // Choisir un prénom masculin ou féminin selon le genre
            $firstName = $isMale
                ? $prenomMasculinCongolais[array_rand($prenomMasculinCongolais)]
                : $prenomFemininCongolais[array_rand($prenomFemininCongolais)];

            // Choisir un nom de famille congolais aléatoire
            $lastName = $nomCongolais[array_rand($nomCongolais)];

            // Remplissage des informations du profil
            $profile->setName($lastName);
            $profile->setPostname($faker->lastName); // Utilisez un nom de famille supplémentaire aléatoire
            $profile->setFirstname($firstName);

            // Générer un numéro de téléphone commençant par 243 et de 12 chiffres au total
            $profile->setPhone('243' . $faker->numerify('#########'));

            $profile->setAddress($faker->address);
            $profile->setDateOfBirth($faker->dateTimeBetween('-50 years', '-18 years'));
            $profile->setDateCreation(new \DateTime());
            $profile->setDateInscrit(new \DateTime());

            // Création du Passport
            $passport = new Passport();
            $passport->setNumberPassport('CD' . strtoupper($faker->bothify('#######')));
            $passport->setDateExpiration($faker->dateTimeBetween('+5 years', '+10 years'));
            $passport->setNationalite('Congolais');
            $passport->setProfession($faker->jobTitle);
            $passport->setStatusDemarches($faker->randomElement(['En cours', 'Valider', 'En attente']));

            $manager->persist($passport);

            $profile->setPassport($passport);
            $manager->persist($profile);

            // Référence pour lier le profil à un utilisateur dans les autres fixtures
            $this->addReference('profile_' . $i, $profile);
        }

        $manager->flush();
    }
}
