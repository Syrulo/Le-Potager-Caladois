<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

/**
 * Classe de fixtures pour charger des données de test pour les utilisateurs.
 */
class UtilisateurFixtures extends Fixture
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
     * Charge les données de test pour les utilisateurs.
     *
     * @param ObjectManager $manager Le gestionnaire d'entités pour persister les données.
     */
    public function load(ObjectManager $manager): void
    {
            // Créer 10 Utilisateur
            for ($i = 0; $i < 10; $i++) { 
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($this->faker->email())
                            ->setRoles(['ROLE_USER'])
                            ->setActive(true)
                            ->setPlainPassword('password');

                $manager->persist($utilisateur);
                $this->addReference('utilisateur'.$i, $utilisateur);
            }
            
            $manager->flush();
            
        }
    }   