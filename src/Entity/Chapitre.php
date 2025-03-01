<?php

namespace App\Entity;

use App\Repository\ChapitreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChapitreRepository::class)]
class Chapitre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?bool $quiz = null;

    #[ORM\Column]
    private ?bool $TD = null;

    #[ORM\ManyToOne(inversedBy: 'NbrChapitre')]
    private ?Matiere $NomMatiere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function isQuiz(): ?bool
    {
        return $this->quiz;
    }

    public function setQuiz(bool $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function isTD(): ?bool
    {
        return $this->TD;
    }

    public function setTD(bool $TD): static
    {
        $this->TD = $TD;

        return $this;
    }

    public function getNomMatiere(): ?Matiere
    {
        return $this->NomMatiere;
    }

    public function setNomMatiere(?Matiere $NomMatiere): static
    {
        $this->NomMatiere = $NomMatiere;

        return $this;
    }
}
