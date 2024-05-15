<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    
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
            }
            
            $manager->flush();
        }
    }   