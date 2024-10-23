<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VisitorRepository;

#[ORM\Entity(repositoryClass: VisitorRepository::class)]
class Visitor extends User
{

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    /**
     * @var Collection<int, Producer>
     */
    #[ORM\OneToMany(targetEntity: Producer::class, mappedBy: 'visitor')]
    private Collection $producers;

    public function __construct()
    {
        $this->producers = new ArrayCollection();
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Producer>
     */
    public function getProducers(): Collection
    {
        return $this->producers;
    }

    public function addProducer(Producer $producer): static
    {
        if (!$this->producers->contains($producer)) {
            $this->producers->add($producer);
            $producer->setVisitor($this);
        }

        return $this;
    }

    public function removeProducer(Producer $producer): static
    {
        if ($this->producers->removeElement($producer)) {
            // set the owning side to null (unless already changed)
            if ($producer->getVisitor() === $this) {
                $producer->setVisitor(null);
            }
        }

        return $this;
    }
   
}
