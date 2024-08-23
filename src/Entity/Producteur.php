<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\ProducteurRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ProducteurRepository::class)]
#[UniqueEntity(fields: 'email', message: 'Il existe déjà un compte avec cet email.')]
#[Vich\Uploadable]
#[HasLifecycleCallbacks]
class Producteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, nullable: true)]
    #[Assert\Length(min: 2, max: 180)]
    private ?string $nom = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min: 2, max: 180)]
    private ?string $email;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column(length: 10, nullable: true, unique: true)]
    private ?string $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 80, nullable: true)]
    #[Assert\Length(min: 2, max: 80)]
    private ?string $ville = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?int $code_postal = null;

    #[Vich\UploadableField(mapping: 'producteurs_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\Column]
    private ?int $imageSize = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'producteur')]
    private Collection $produits;

    #[ORM\OneToOne(inversedBy: 'producteur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    /**
     * Constructeur de la classe Producteur.
     *
     * Initialise les propriétés createdAt, updatedAt et produits.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime('now');
        $this->produits = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant du producteur.
     *
     * @return int|null L'identifiant du producteur ou null si non défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom du producteur.
     *
     * @return string|null Le nom du producteur ou null si non défini.
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Définit le nom du producteur.
     *
     * @param string $nom Le nom du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Retourne l'email du producteur.
     *
     * @return string|null L'email du producteur ou null si non défini.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Définit l'email du producteur.
     *
     * @param string $email L'email du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Retourne la description du producteur.
     *
     * @return string|null La description du producteur ou null si non défini.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Définit la description du producteur.
     *
     * @param string $description La description du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Retourne le numéro de téléphone du producteur.
     *
     * @return string|null Le numéro de téléphone du producteur ou null si non défini.
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * Définit le numéro de téléphone du producteur.
     *
     * @param string $tel Le numéro de téléphone du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Retourne l'adresse du producteur.
     *
     * @return string|null L'adresse du producteur ou null si non défini.
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * Définit l'adresse du producteur.
     *
     * @param string $adresse L'adresse du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Retourne la ville du producteur.
     *
     * @return string|null La ville du producteur ou null si non défini.
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * Définit la ville du producteur.
     *
     * @param string $ville La ville du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Retourne le code postal du producteur.
     *
     * @return int|null Le code postal du producteur ou null si non défini.
     */
    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    /**
     * Définit le code postal du producteur.
     *
     * @param int $code_postal Le code postal du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setCodePostal(int $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * Définit le fichier image du producteur.
     *
     * @param File|null $imageFile Le fichier image du producteur.
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Retourne le fichier image du producteur.
     *
     * @return File|null Le fichier image du producteur ou null si non défini.
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Définit le nom de l'image du producteur.
     *
     * @param string|null $imageName Le nom de l'image du producteur.
     */
    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * Retourne le nom de l'image du producteur.
     *
     * @return string|null Le nom de l'image du producteur ou null si non défini.
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Définit la taille de l'image du producteur.
     *
     * @param int|null $imageSize La taille de l'image du producteur.
     */
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    /**
     * Retourne la taille de l'image du producteur.
     *
     * @return int|null La taille de l'image du producteur ou null si non défini.
     */
    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * Retourne la date de création du producteur.
     *
     * @return \DateTimeImmutable|null La date de création du producteur ou null si non défini.
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Définit la date de création du producteur.
     *
     * @param \DateTimeImmutable|null $createdAt La date de création du producteur.
     * @return self L'instance du producteur pour permettre le chaînage.
     */
    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Retourne la date de mise à jour du producteur.
     *
     * @return \DateTimeInterface|null La date de mise à jour du producteur ou null si non défini.
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Définit la date de mise à jour du producteur.
     *
     * @param \DateTimeInterface|null $updatedAt La date de mise à jour du producteur.
     * @return self L'instance du producteur pour permettre le chaînage.
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Retourne le slug du producteur.
     *
     * @return string|null Le slug du producteur ou null si non défini.
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Définit le slug du producteur.
     *
     * @param string $slug Le slug du producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setSlug(string $slug): static
    {
        $slugger = new AsciiSlugger();
        $this->slug = $slugger->slug($slug);
        unset($slugger);
        return $this;
    }

    /**
     * Définit automatiquement la valeur du slug avant la persistance ou la mise à jour.
     */
    #[PrePersist]
    #[PreUpdate]
    public function setSlugValue(): void
    {
        $slugger = new AsciiSlugger();
        $this->slug = $slugger->slug($this->nom);
        unset($slugger);
    }

    /**
     * Retourne une collection de produits associés au producteur.
     *
     * @return Collection<int, Produit> La collection de produits associés au producteur.
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    /**
     * Ajoute un produit à la collection de produits associés au producteur.
     *
     * @param Produit $produit Le produit à ajouter.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setProducteur($this);
        }

        return $this;
    }

    /**
     * Supprime un produit de la collection de produits associés au producteur.
     *
     * @param Produit $produit Le produit à supprimer.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getProducteur() === $this) {
                $produit->setProducteur(null);
            }
        }

        return $this;
    }

    /**
     * Retourne l'utilisateur associé au producteur.
     *
     * @return Utilisateur|null L'utilisateur associé au producteur ou null si non défini.
     */
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * Définit l'utilisateur associé au producteur.
     *
     * @param Utilisateur $utilisateur L'utilisateur à associer au producteur.
     * @return static L'instance du producteur pour permettre le chaînage.
     */
    public function setUtilisateur(Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
    
}
