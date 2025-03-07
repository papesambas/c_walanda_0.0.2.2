<?php

namespace App\Entity;

use App\Repository\Telephones1Repository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: Telephones1Repository::class)]
class Telephones1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 23, unique:true)]
    #[Assert\NotBlank(message: 'Username cannot be blank.')]
    #[Assert\Length(
        min: 12,
        max: 23,
        minMessage: 'Phone number must be at least {{ limit }} characters long.',
        maxMessage: 'Phone number cannot be longer than {{ limit }} characters.'
    )]
    private ?string $numero = null;

    #[ORM\OneToOne(mappedBy: 'telephone1', cascade: ['persist', 'remove'])]
    private ?Peres $peres = null;

    #[ORM\OneToOne(mappedBy: 'telephone1', cascade: ['persist', 'remove'])]
    private ?Meres $meres = null;

    public function __tostring()
    {
        return $this->numero ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPeres(): ?Peres
    {
        return $this->peres;
    }

    public function setPeres(Peres $peres): static
    {
        // set the owning side of the relation if necessary
        if ($peres->getTelephone1() !== $this) {
            $peres->setTelephone1($this);
        }

        $this->peres = $peres;

        return $this;
    }

    public function getMeres(): ?Meres
    {
        return $this->meres;
    }

    public function setMeres(Meres $meres): static
    {
        // set the owning side of the relation if necessary
        if ($meres->getTelephone1() !== $this) {
            $meres->setTelephone1($this);
        }

        $this->meres = $meres;

        return $this;
    }
}
