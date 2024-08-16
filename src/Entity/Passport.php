<?php

namespace App\Entity;

use App\Repository\PassportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassportRepository::class)]
class Passport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $number_Passport = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $date_expira = null;

    #[ORM\Column(length: 100)]
    private ?string $nationalité = null;

    #[ORM\Column(length: 100)]
    private ?string $profession = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberPassport(): ?string
    {
        return $this->number_Passport;
    }

    public function setNumberPassport(string $number_Passport): static
    {
        $this->number_Passport = $number_Passport;

        return $this;
    }

    public function getDateExpira(): ?string
    {
        return $this->date_expira;
    }

    public function setDateExpira(string $date_expira): static
    {
        $this->date_expira = $date_expira;

        return $this;
    }

    public function getNationalité(): ?string
    {
        return $this->nationalité;
    }

    public function setNationalité(string $nationalité): static
    {
        $this->nationalité = $nationalité;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }
}
