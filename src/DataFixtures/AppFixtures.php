<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Etudiant;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Create Genres
        for ($i = 0; $i < 5; $i++) {
            $genre = new Genre();
            $genre->setNom($faker->word);
            $genre->setDescription($faker->sentence);
            $manager->persist($genre);

            // Create Livres for each Genre
            for ($j = 0; $j < 3; $j++) {
                $livre = new Livre();
                $livre->setTitre($faker->sentence);
                $livre->setEditeur($faker->company);
                $livre->setAuteur($faker->name);
                $livre->setIsbn($faker->isbn13);
                $livre->setDatePublication($faker->dateTimeThisCentury);
                $livre->setImage($faker->imageUrl());
                $livre->setResume($faker->paragraph);
                $genre->addLivre($livre);
                $manager->persist($livre);
            }
        }

        // Create Etudiants
        for ($i = 0; $i < 10; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setEmail($faker->email);
            $etudiant->setRoles(['ROLE_USER']);
            $etudiant->setPassword(password_hash('password', PASSWORD_BCRYPT)); // Set a default password
            $etudiant->setNom($faker->lastName);
            $etudiant->setPrenom($faker->firstName);
            $etudiant->setTelephone($faker->phoneNumber);
            $etudiant->setAvatar($faker->imageUrl());
            $manager->persist($etudiant);
        }

        $manager->flush();
    }
}
