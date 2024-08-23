<?php

namespace App\DataFixtures;

use App\DataFixtures\UtilisateurFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\UtilisateurDetails;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

/**
 * Classe de fixtures pour charger des données de test pour les détails des utilisateurs.
 */
class UtilisateurDetailsFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @var Generator
     */
    private Generator $faker;

    /**
     * Constructeur pour initialiser le générateur Faker.
     */
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    
    /**
     * Charge les données de test pour les détails des utilisateurs.
     *
     * @param ObjectManager $manager Le gestionnaire d'entités pour persister les données.
     */
    public function load(ObjectManager $manager): void
    {
            // Créer 10 Utilisateur
            for ($i = 0; $i < 10; $i++) { 
                $utilisateur = new UtilisateurDetails();
                $utilisateur->setUtilisateur($this->getReference('utilisateur'.$i));
                $utilisateur->setPrenom($this->faker->firstName())
                            ->setNom($this->faker->lastName())
                            ->setTel($this->faker->phoneNumber())
                            ->setAdresse($this->faker->address());

                $manager->persist($utilisateur);
            }
            
            $manager->flush();

        }
        /**
         * Retourne les dépendances de cette fixture.
         *
         * @return array Un tableau de classes de fixtures dont cette fixture dépend.
         */
        public function getDependencies(): array
        {
            return [
                UtilisateurFixtures::class
            ];
        }
    }   