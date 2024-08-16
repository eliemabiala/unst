<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $date_update = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $object = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Creation_Date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateUpdate(): ?string
    {
        return $this->date_update;
    }

    public function setDateUpdate(string $date_update): static
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): static
    {
        $this->object = $object;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->Creation_Date;
    }

    public function setCreationDate(\DateTimeInterface $Creation_Date): static
    {
        $this->Creation_Date = $Creation_Date;

        return $this;
    }
}
