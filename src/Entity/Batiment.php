<?php

namespace App\Entity;

use App\Repository\BatimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BatimentRepository::class)
 */
class Batiment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBatiment;

    /**
     * @ORM\OneToMany(targetEntity=Chambre::class, mappedBy="batiment", orphanRemoval=true)
     */
    private $chambre;

    public function __construct()
    {
        $this->chambre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBatiment(): ?string
    {
        return $this->nomBatiment;
    }

    public function setNomBatiment(string $nomBatiment): self
    {
        $this->nomBatiment = $nomBatiment;

        return $this;
    }

    /**
     * @return Collection|Chambre[]
     */
    public function getChambre(): Collection
    {
        return $this->chambre;
    }

    public function addChambre(Chambre $chambre): self
    {
        if (!$this->chambre->contains($chambre)) {
            $this->chambre[] = $chambre;
            $chambre->setBatiment($this);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): self
    {
        if ($this->chambre->contains($chambre)) {
            $this->chambre->removeElement($chambre);
            // set the owning side to null (unless already changed)
            if ($chambre->getBatiment() === $this) {
                $chambre->setBatiment(null);
            }
        }

        return $this;
    }
}
