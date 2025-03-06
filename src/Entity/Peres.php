<?php

namespace App\Entity;

use App\Repository\PeresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeresRepository::class)]
class Peres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'peres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Noms $nom = null;

    #[ORM\ManyToOne(inversedBy: 'peres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prenoms $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'peres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professions $profession = null;

    #[ORM\OneToOne(inversedBy: 'peres', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Telephones1 $telephone1 = null;

    #[ORM\OneToOne(inversedBy: 'peres', cascade: ['persist', 'remove'])]
    private ?Telephones2 $telephone2 = null;

    /**
     * @var Collection<int, Parents>
     */
    #[ORM\OneToMany(targetEntity: Parents::class, mappedBy: 'pere')]
    private Collection $parents;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullname = null;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?Noms
    {
        return $this->nom;
    }

    public function setNom(?Noms $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?Prenoms
    {
        return $this->prenom;
    }

    public function setPrenom(?Prenoms $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getProfession(): ?Professions
    {
        return $this->profession;
    }

    public function setProfession(?Professions $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getTelephone1(): ?Telephones1
    {
        return $this->telephone1;
    }

    public function setTelephone1(Telephones1 $telephone1): static
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?Telephones2
    {
        return $this->telephone2;
    }

    public function setTelephone2(?Telephones2 $telephone2): static
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * @return Collection<int, Parents>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Parents $parent): static
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
            $parent->setPere($this);
        }

        return $this;
    }

    public function removeParent(Parents $parent): static
    {
        if ($this->parents->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getPere() === $this) {
                $parent->setPere(null);
            }
        }

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }
}
