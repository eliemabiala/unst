<?php

namespace App\Entity;

use App\Repository\PassportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: PassportRepository::class)]
#[UniqueEntity(
    fields: ['number_passport'],
    message: 'Ce numéro de passeport est déjà utilisé.'
)]
class Passport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)] // Ajout de unique: true au niveau de la DB
    #[Assert\NotBlank(message: 'Le numéro de passeport ne peut pas être vide.')]
    #[Assert\Callback]
    private ?string $number_passport = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_expiration = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $profession = null;

    #[ORM\OneToOne(mappedBy: 'passport', cascade: ['persist', 'remove'])]
    private ?Profile $profile = null;

    // Validation personnalisée pour vérifier l'unicité conditionnelle
    public function validateUniqueNumberPassport(ExecutionContextInterface $context): void
    {
        $entityManager = $context->getRoot()->getConfig()->getOption('entity_manager');

        if ($this->number_passport) {
            $existingPassport = $entityManager->getRepository(Passport::class)
                ->findOneBy(['number_passport' => $this->number_passport]);

            if ($existingPassport && $existingPassport->getId() !== $this->getId()) {
                $context->buildViolation('Ce numéro de passeport est déjà utilisé.')
                    ->atPath('number_passport')
                    ->addViolation();
            }
        }
    }

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberPassport(): ?string
    {
        return $this->number_passport;
    }

    public function setNumberPassport(string $number_passport): static
    {
        $this->number_passport = $number_passport;
        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(?\DateTimeInterface $date_expiration): static
    {
        $this->date_expiration = $date_expiration;
        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): static
    {
        $this->nationalite = $nationalite;
        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;
        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): static
    {
        if ($profile->getPassport() !== $this) {
            $profile->setPassport($this);
        }

        $this->profile = $profile;
        return $this;
    }
}
