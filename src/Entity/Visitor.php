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
    private Collection $procuders;

    public function __construct()
    {
        $this->procuders = new ArrayCollection();
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
    public function getProcuders(): Collection
    {
        return $this->procuders;
    }

    public function addProcuder(Producer $procuder): static
    {
        if (!$this->procuders->contains($procuder)) {
            $this->procuders->add($procuder);
            $procuder->setVisitor($this);
        }

        return $this;
    }

    public function removeProcuder(Producer $procuder): static
    {
        if ($this->procuders->removeElement($procuder)) {
            // set the owning side to null (unless already changed)
            if ($procuder->getVisitor() === $this) {
                $procuder->setVisitor(null);
            }
        }

        return $this;
    }
   
}
