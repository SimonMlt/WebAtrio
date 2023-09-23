<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull()]
    #[Assert\GreaterThan('-150 years')]
    #[Assert\LessThan('today')]
    private ?\DateTimeInterface $dateNaissance = null;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge()
    {
        $now = new \DateTime('now');
        $age = $this->getDateNaissance();
        $difference = $now->diff($age);

        return $difference->format('%y ans');
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }
}
