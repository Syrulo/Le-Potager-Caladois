<?php

namespace App\Entity;

use App\Repository\ProducerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProducerRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Producer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brandName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $phone = null;

    #[Vich\UploadableField(mapping: 'producteurs_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'producer', cascade: ['remove'])]
    private Collection $products;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    #[ORM\OneToOne(inversedBy: 'producer', cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    private ?Visitor $visitor = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(?string $brandName): static
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Définit le fichier image du producteur.
     *
     * @param File|null $imageFile le fichier image du producteur
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
     * @return File|null le fichier image du producteur ou null si non défini
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Définit le nom de l'image du producteur.
     *
     * @param string|null $imageName le nom de l'image du producteur
     */
    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * Retourne le nom de l'image du producteur.
     *
     * @return string|null le nom de l'image du producteur ou null si non défini
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Définit la taille de l'image du producteur.
     *
     * @param int|null $imageSize la taille de l'image du producteur
     */
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    /**
     * Retourne la taille de l'image du producteur.
     *
     * @return int|null la taille de l'image du producteur ou null si non défini
     */
    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new \DateTimeImmutable('now');

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Retourne une collection de produits associés au producteur.
     *
     * @return Collection<int, Product> la collection de produits associés au producteur
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * Ajoute un produit à la collection de produits associés au producteur.
     *
     * @return static L'instance du producteur pour permettre le chaînage
     */
    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setProducer($this);
        }

        return $this;
    }

    /**
     * Supprime un produit de la collection de produits associés au producteur.
     *
     * @return static L'instance du producteur pour permettre le chaînage
     */
    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProducer() === $this) {
                $product->setProducer(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
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
        $this->slug = $slugger->slug($this->brandName);
        unset($slugger);
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getVisitor(): ?Visitor
    {
        return $this->visitor;
    }

    public function setVisitor(Visitor $visitor): static
    {
        $this->visitor = $visitor;

        return $this;
    }
}
