<?php

namespace App\Entity;

use App\Repository\EmploiRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmploiRepository::class)]
class Emploi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jour = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $hr_deb = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $hr_fin = null;

    #[ORM\ManyToOne(targetEntity: Salles::class)]
    #[ORM\JoinColumn(name: 'salle_id', referencedColumnName: 'id')]
    private ?Salles $Salle = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHrDeb(): ?\DateTimeInterface
    {
        return $this->hr_deb;
    }

    public function setHrDeb(\DateTimeInterface $hr_deb): static
    {
        $this->hr_deb = $hr_deb;

        return $this;
    }

    public function getHrFin(): ?\DateTimeInterface
    {
        return $this->hr_fin;
    }

    public function setHrFin(\DateTimeInterface $hr_fin): static
    {
        $this->hr_fin = $hr_fin;

        return $this;
    }


    
    public function getSalle(): ?Salles
    {
        return $this->Salle;
    }
    
    public function setSalle(?Salles $salle): static
    {
        $this->Salle = $salle;
    
        return $this;
    }
}
