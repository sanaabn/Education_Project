<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $coeficient = null;

    #[ORM\Column]
    private ?int $nombreDesHeures = null;

    #[ORM\Column(length: 255)]
    private ?string $modeDevaluation = null;

    /**
     * @var Collection<int, Chapitre>
     */
    #[ORM\OneToMany(targetEntity: Chapitre::class, mappedBy: 'NomMatiere')]
    private Collection $NbrChapitre;

    public function __construct()
    {
        $this->NbrChapitre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCoeficient(): ?int
    {
        return $this->coeficient;
    }

    public function setCoeficient(int $coeficient): static
    {
        $this->coeficient = $coeficient;

        return $this;
    }

    public function getNombreDesHeures(): ?int
    {
        return $this->nombreDesHeures;
    }

    public function setNombreDesHeures(int $nombreDesHeures): static
    {
        $this->nombreDesHeures = $nombreDesHeures;

        return $this;
    }

    public function getModeDevaluation(): ?string
    {
        return $this->modeDevaluation;
    }

    public function setModeDevaluation(string $modeDevaluation): static
    {
        $this->modeDevaluation = $modeDevaluation;

        return $this;
    }

    /**
     * @return Collection<int, Chapitre>
     */
    public function getNbrChapitre(): Collection
    {
        return $this->NbrChapitre;
    }

    public function addNbrChapitre(Chapitre $nbrChapitre): static
    {
        if (!$this->NbrChapitre->contains($nbrChapitre)) {
            $this->NbrChapitre->add($nbrChapitre);
            $nbrChapitre->setNomMatiere($this);
        }

        return $this;
    }

    public function removeNbrChapitre(Chapitre $nbrChapitre): static
    {
        if ($this->NbrChapitre->removeElement($nbrChapitre)) {
            // set the owning side to null (unless already changed)
            if ($nbrChapitre->getNomMatiere() === $this) {
                $nbrChapitre->setNomMatiere(null);
            }
        }

        return $this;
    }
}
