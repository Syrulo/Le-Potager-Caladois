<?php

namespace App\EntityListener;

use App\Entity\Utilisateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Listener pour l'entité Utilisateur.
 *
 * Gère l'encodage du mot de passe avant la persistance et la mise à jour.
 */
class UtilisateurListener
{
    
    private UserPasswordHasherInterface $hasher;

    /**
     * Constructeur de la classe UtilisateurListener.
     *
     * @param UserPasswordHasherInterface $hasher Le service de hachage de mot de passe.
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Méthode appelée avant la persistance d'un utilisateur.
     *
     * @param Utilisateur $utilisateur L'utilisateur à persister.
     */
    public function prePersist(Utilisateur $utilisateur)
    {
        $this->encodePassword($utilisateur);
    }

    /**
     * Méthode appelée avant la mise à jour d'un utilisateur.
     *
     * @param Utilisateur $utilisateur L'utilisateur à mettre à jour.
     */
    public function preUpdate(Utilisateur $utilisateur)
    {
        $this->encodePassword($utilisateur);
    }

    /**
     * Encode le mot de passe basé sur le plainPassword.
     *
     * @param Utilisateur $utilisateur L'utilisateur dont le mot de passe doit être encodé.
     * @return void
     */
    public function encodePassword(Utilisateur $utilisateur)
    {
        if($utilisateur->getPlainPassword() === null) {
            return;
        }

        $utilisateur->setPassword(
            $this->hasher->hashPassword(
                $utilisateur,
                $utilisateur->getPlainPassword()
            )
        );

        $utilisateur->setPlainPassword(null);
    }
}