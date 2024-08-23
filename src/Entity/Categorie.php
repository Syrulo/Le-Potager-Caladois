<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[Vich\Uploadable]
#[HasLifecycleCallbacks]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    private ?string $nom = null;

    #[Vich\UploadableField(mapping: 'categories_image', fileNameProperty: 'imageName', size: 'imageSize')]
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
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'categorie')]
    private Collection $produits;

    /**
     * Constructeur de la classe Categorie.
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
     * Retourne l'identifiant de la catégorie.
     *
     * @return int|null L'identifiant de la catégorie ou null si non défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom de la catégorie.
     *
     * @return string|null Le nom de la catégorie ou null si non défini.
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Définit le nom de la catégorie.
     *
     * @param string $nom Le nom de la catégorie.
     * @return static L'instance de la catégorie pour permettre le chaînage.
     */
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Définit le fichier image de la catégorie.
     *
     * @param File|null $imageFile Le fichier image de la catégorie.
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Retourne le fichier image de la catégorie.
     *
     * @return File|null Le fichier image de la catégorie ou null si non défini.
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Définit le nom de l'image de la catégorie.
     *
     * @param string|null $imageName Le nom de l'image de la catégorie.
     */
    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * Retourne le nom de l'image de la catégorie.
     *
     * @return string|null Le nom de l'image de la catégorie ou null si non défini.
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Définit la taille de l'image de la catégorie.
     *
     * @param int|null $imageSize La taille de l'image de la catégorie.
     */
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    /**
     * Retourne la taille de l'image de la catégorie.
     *
     * @return int|null La taille de l'image de la catégorie ou null si non défini.
     */
    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * Retourne la date de création de la catégorie.
     *
     * @return \DateTimeImmutable|null La date de création de la catégorie ou null si non défini.
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Définit la date de création de la catégorie.
     *
     * @param \DateTimeImmutable $createdAt La date de création de la catégorie.
     * @return static L'instance de la catégorie pour permettre le chaînage.
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Retourne la date de mise à jour de la catégorie.
     *
     * @return \DateTimeInterface|null La date de mise à jour de la catégorie ou null si non défini.
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Définit la date de mise à jour de la catégorie.
     *
     * @param \DateTimeInterface|null $updatedAt La date de mise à jour de la catégorie.
     * @return self L'instance de la catégorie pour permettre le chaînage.
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Retourne le slug de la catégorie.
     *
     * @return string|null Le slug de la catégorie ou null si non défini.
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Définit le slug de la catégorie.
     *
     * @param string $slug Le slug de la catégorie.
     * @return static L'instance de la catégorie pour permettre le chaînage.
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
     * Retourne le nom de la catégorie sous forme de chaîne de caractères.
     *
     * @return string Le nom de la catégorie.
     */
    public function __toString(): string
    {
        return $this->nom;
    }

    /**
     * Retourne une collection de produits associés à la catégorie.
     *
     * @return Collection<int, Produit> La collection de produits associés à la catégorie.
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    /**
     * Ajoute un produit à la collection de produits associés à la catégorie.
     *
     * @param Produit $produit Le produit à ajouter.
     * @return static L'instance de la catégorie pour permettre le chaînage.
     */
    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setCategorie($this);
        }

        return $this;
    }

    /**
     * Supprime un produit de la collection de produits associés à la catégorie.
     *
     * @param Produit $produit Le produit à supprimer.
     * @return static L'instance de la catégorie pour permettre le chaînage.
     */
    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorie() === $this) {
                $produit->setCategorie(null);
            }
        }

        return $this;
    }
}
