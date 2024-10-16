<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
// #[ORM\EntityListeners(['App\EntityListener\UtilisateurListener'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: 'email', message: 'Veuillez choisir une autre adresse email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min: 2, max: 180)]
    private ?string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = "password";

    #[ORM\Column]
    private ?bool $is_active = false;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $created_at = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToOne(targetEntity: "App\Entity\UtilisateurDetails", mappedBy: "utilisateur", cascade: ["persist", "remove"])]
    private $utilisateurDetails;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Producteur $producteur = null;

    /**
     * Constructeur de la classe Utilisateur.
     *
     * Initialise les propriétés created_at et updatedAt.
     */
    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Retourne l'identifiant de l'utilisateur.
     *
     * @return int|null L'identifiant de l'utilisateur ou null si non défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne l'email de l'utilisateur.
     *
     * @return string|null L'email de l'utilisateur ou null si non défini.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Définit l'email de l'utilisateur.
     *
     * @param string $email L'email de l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Un identifiant visuel qui représente cet utilisateur.
     *
     * @see UserInterface
     * @return string L'identifiant de l'utilisateur.
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Retourne les rôles de l'utilisateur.
     *
     * @see UserInterface
     * @return list<string> La liste des rôles de l'utilisateur.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Définit les rôles de l'utilisateur.
     *
     * @param list<string> $roles La liste des rôles de l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Retourne la valeur de plainPassword.
     *
     * @return string|null Le mot de passe en clair de l'utilisateur ou null si non défini.
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Définit la valeur de plainPassword.
     *
     * @param string $plainPassword Le mot de passe en clair de l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Retourne le mot de passe de l'utilisateur.
     *
     * @see PasswordAuthenticatedUserInterface
     * @return string Le mot de passe de l'utilisateur.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Définit le mot de passe de l'utilisateur.
     *
     * @param string $password Le mot de passe de l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Retourne si l'utilisateur est actif.
     *
     * @return bool|null True si l'utilisateur est actif, sinon false.
     */
    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    /**
     * Définit si l'utilisateur est actif.
     *
     * @param bool $is_active True si l'utilisateur est actif, sinon false.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * Retourne la date de création de l'utilisateur.
     *
     * @return \DateTimeImmutable|null La date de création de l'utilisateur ou null si non défini.
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * Définit la date de création de l'utilisateur.
     *
     * @param \DateTimeImmutable $created_at La date de création de l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Retourne la date de mise à jour de l'utilisateur.
     *
     * @return \DateTimeInterface|null La date de mise à jour de l'utilisateur ou null si non défini.
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Définit la date de mise à jour de l'utilisateur.
     *
     * @param \DateTimeInterface|null $updatedAt La date de mise à jour de l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Retourne les détails de l'utilisateur.
     *
     * @return UtilisateurDetails|null Les détails de l'utilisateur ou null si non défini.
     */
    public function getUtilisateurDetails(): ?UtilisateurDetails
    {
        return $this->utilisateurDetails;
    }

    /**
     * Définit les détails de l'utilisateur.
     *
     * @param UtilisateurDetails $utilisateurDetails Les détails de l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     */
    public function setUtilisateurDetails(UtilisateurDetails $utilisateurDetails): self
    {
    $this->utilisateurDetails = $utilisateurDetails;

    // Définir le côté propriétaire de la relation si nécessaire
    if ($utilisateurDetails->getUtilisateur() !== $this) {
        $utilisateurDetails->setUtilisateur($this);
        }

    return $this;
    }

    /**
     * Retourne le prénom des détails de l'utilisateur.
     *
     * @return string|null Le prénom des détails de l'utilisateur ou null si non défini.
     */
    public function getUtilisateurDetailsPrenom(): ?string
    {
        return $this->utilisateurDetails ? $this->utilisateurDetails->getPrenom() : null;
    }

    /**
     * Retourne le producteur associé à l'utilisateur.
     *
     * @return Producteur|null Le producteur associé à l'utilisateur ou null si non défini.
     */
    public function getProducteur(): ?Producteur
    {
        return $this->producteur;
    }

    /**
     * Définit le producteur associé à l'utilisateur.
     *
     * @param Producteur $producteur Le producteur à associer à l'utilisateur.
     * @return static L'instance de l'utilisateur pour permettre le chaînage.
     * @throws \Exception Si un producteur existe déjà pour cet utilisateur.
     */    
    public function setProducteur(Producteur $producteur): static
    {
        // Vérifier si le producteur existe déjà pour cet utilisateur
        if ($this->producteur !== null && $this->producteur !== $producteur) {
            throw new \Exception('Duplicate entry for producteur');
        }
        
        // Définir le côté propriétaire de la relation si nécessaire
        if ($producteur->getUtilisateur() !== $this) {
            $producteur->setUtilisateur($this);
        }
        
        $this->producteur = $producteur;
        return $this;
    }

    /**
     * Efface les informations d'identification sensibles de l'utilisateur.
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // Si vous stockez des données temporaires et sensibles sur l'utilisateur, effacez-les ici
        // $this->plainPassword = null;
    }
}
