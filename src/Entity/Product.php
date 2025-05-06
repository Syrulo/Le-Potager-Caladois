<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Vich\Uploadable]
#[HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'produits_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Producer $producer = null;

    /**
     * Constructeur de la classe Produit.
     *
     * Initialise les propriétés createdAt et updatedAt.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * Retourne l'identifiant du produit.
     *
     * @return int|null L'identifiant du produit ou null si non défini
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom du produit.
     *
     * @return string|null le nom du produit ou null si non défini
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Définit le nom du produit.
     *
     * @param string $nom le nom du produit
     *
     * @return static L'instance du produit pour permettre le chaînage
     */
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Retourne le prix du produit.
     *
     * @return float|null le prix du produit ou null si non défini
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     * Définit le prix du produit.
     *
     * @param float $prix le prix du produit
     *
     * @return static L'instance du produit pour permettre le chaînage
     */
    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Retourne la description du produit.
     *
     * @return string|null la description du produit ou null si non défini
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Définit la description du produit.
     *
     * @param string $description la description du produit
     *
     * @return static L'instance du produit pour permettre le chaînage
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Définit le fichier image du produit.
     *
     * @param File|null $imageFile le fichier image du produit
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Retourne le fichier image du produit.
     *
     * @return File|null le fichier image du produit ou null si non défini
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Définit le nom de l'image du produit.
     *
     * @param string|null $imageName le nom de l'image du produit
     */
    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * Retourne le nom de l'image du produit.
     *
     * @return string|null le nom de l'image du produit ou null si non défini
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Définit la taille de l'image du produit.
     *
     * @param int|null $imageSize la taille de l'image du produit
     */
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    /**
     * Retourne la taille de l'image du produit.
     *
     * @return int|null la taille de l'image du produit ou null si non défini
     */
    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * Retourne la date de création du produit.
     *
     * @return \DateTimeImmutable|null la date de création du produit ou null si non défini
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Définit la date de création du produit.
     *
     * @param \DateTimeImmutable $createdAt la date de création du produit
     *
     * @return static L'instance du produit pour permettre le chaînage
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Retourne la date de mise à jour du produit.
     *
     * @return \DateTimeInterface|null la date de mise à jour du produit ou null si non défini
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Définit la date de mise à jour du produit.
     *
     * @param \DateTimeImmutable|null $updatedAt la date de mise à jour du produit
     *
     * @return static L'instance du produit pour permettre le chaînage
     */
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Retourne le slug du produit.
     *
     * @return string|null le slug du produit ou null si non défini
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Définit le slug du produit.
     *
     * @param string $slug le slug du produit
     *
     * @return static L'instance du produit pour permettre le chaînage
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
     * Retourne la catégorie associée au produit.
     *
     * @return Category|null la catégorie associée au produit ou null si non défini
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Définit la catégorie associée au produit.
     *
     * @param Category|null $category la catégorie à associer au produit
     *
     * @return static L'instance du produit pour permettre le chaînage
     */
    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Retourne le producteur associé au produit.
     *
     * @return Producer|null le producteur associé au produit ou null si non défini
     */
    public function getProducer(): ?Producer
    {
        return $this->producer;
    }

    /**
     * Définit le producteur associé au produit.
     *
     * @return static L'instance du produit pour permettre le chaînage
     */
    public function setProducer(?Producer $producer): static
    {
        $this->producer = $producer;

        return $this;
    }
}
