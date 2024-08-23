<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurDetailsRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurDetailsRepository::class)]
class UtilisateurDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 10, nullable: true, unique: true)]
    #[Assert\Length(min: 10, max: 10)]
    private ?string $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 80, nullable: true)]
    #[Assert\Length(min: 2, max: 80)]
    private ?string $ville = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Assert\Length(min: 5, max: 5)]
    private ?int $code_postal = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToOne(targetEntity: "App\Entity\Utilisateur", inversedBy: "utilisateurDetails",cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    /**
     * Constructeur de la classe UtilisateurDetails.
     *
     * Initialise les propriétés createdAt et updatedAt.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Retourne l'identifiant des détails de l'utilisateur.
     *
     * @return int|null L'identifiant des détails de l'utilisateur ou null si non défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le prénom de l'utilisateur.
     *
     * @return string|null Le prénom de l'utilisateur ou null si non défini.
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * Définit le prénom de l'utilisateur.
     *
     * @param string $prenom Le prénom de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Retourne le nom de l'utilisateur.
     *
     * @return string|null Le nom de l'utilisateur ou null si non défini.
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Définit le nom de l'utilisateur.
     *
     * @param string $nom Le nom de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Retourne le numéro de téléphone de l'utilisateur.
     *
     * @return string|null Le numéro de téléphone de l'utilisateur ou null si non défini.
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * Définit le numéro de téléphone de l'utilisateur.
     *
     * @param string $tel Le numéro de téléphone de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Retourne l'adresse de l'utilisateur.
     *
     * @return string|null L'adresse de l'utilisateur ou null si non défini.
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * Définit l'adresse de l'utilisateur.
     *
     * @param string $adresse L'adresse de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Retourne la ville de l'utilisateur.
     *
     * @return string|null La ville de l'utilisateur ou null si non défini.
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * Définit la ville de l'utilisateur.
     *
     * @param string $ville La ville de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Retourne le code postal de l'utilisateur.
     *
     * @return int|null Le code postal de l'utilisateur ou null si non défini.
     */
    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    /**
     * Définit le code postal de l'utilisateur.
     *
     * @param int $code_postal Le code postal de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setCodePostal(int $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * Retourne la date de création des détails de l'utilisateur.
     *
     * @return \DateTimeImmutable|null La date de création des détails de l'utilisateur ou null si non défini.
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Définit la date de création des détails de l'utilisateur.
     *
     * @param \DateTimeImmutable $createdAt La date de création des détails de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Retourne la date de mise à jour des détails de l'utilisateur.
     *
     * @return \DateTimeInterface|null La date de mise à jour des détails de l'utilisateur ou null si non défini.
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Définit la date de mise à jour des détails de l'utilisateur.
     *
     * @param \DateTimeInterface|null $updatedAt La date de mise à jour des détails de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Retourne l'utilisateur associé aux détails.
     *
     * @return Utilisateur|null L'utilisateur associé aux détails ou null si non défini.
     */
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * Définit l'utilisateur associé aux détails.
     *
     * @param Utilisateur $utilisateur L'utilisateur à associer aux détails.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setUtilisateur(Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    private $details;

    /**
     * Retourne les détails supplémentaires de l'utilisateur.
     *
     * @return string|null Les détails supplémentaires de l'utilisateur ou null si non défini.
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }

    /**
     * Définit les détails supplémentaires de l'utilisateur.
     *
     * @param string|null $details Les détails supplémentaires de l'utilisateur.
     * @return static L'instance des détails de l'utilisateur pour permettre le chaînage.
     */
    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }
}
