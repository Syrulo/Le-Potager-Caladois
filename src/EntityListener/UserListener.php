<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Listener pour l'entité User.
 *
 * Gère l'encodage du mot de passe avant la persistance et la mise à jour.
 */
class UserListener
{

    private UserPasswordHasherInterface $hasher;

    /**
     * Constructeur de la classe UserListener.
     *
     * @param UserPasswordHasherInterface $hasher Le service de hachage de mot de passe.
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Méthode appelée avant la persistance d'un User.
     *
     * @param User $User L'User à persister.
     */
    public function prePersist(User $User)
    {
        $this->encodePassword($User);
    }

    /**
     * Méthode appelée avant la mise à jour d'un User.
     *
     * @param User $User L'User à mettre à jour.
     */
    public function preUpdate(User $User)
    {
        $this->encodePassword($User);
    }

    /**
     * Encode le mot de passe basé sur le plainPassword.
     *
     * @param User $User L'User dont le mot de passe doit être encodé.
     * @return void
     */
    public function encodePassword(User $User)
    {
        if ($User->getPlainPassword() === null) {
            return;
        }

        $User->setPassword(
            // Le mot de passe est haché avec le service de hachage
            $this->hasher->hashPassword(
                $User,
                $User->getPlainPassword()
            )
        );
        // Ne pas garder le mot de passe en clair
        $User->setPlainPassword(null);
    }
}
