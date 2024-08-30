<?php

namespace App\Entity;

use App\Repository\DocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentsRepository::class)]
class Documents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $file_name = null;

    #[ORM\Column(length: 100)]
    private ?string $file_path = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $download_date = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'documents')]
    private Collection $User;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'documents')]
    private Collection $Step;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->Step = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): static
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(string $file_path): static
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function getDownloadDate(): ?\DateTimeInterface
    {
        return $this->download_date;
    }

    public function setDownloadDate(?\DateTimeInterface $download_date): static
    {
        $this->download_date = $download_date;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
            $user->setDocuments($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->User->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getDocuments() === $this) {
                $user->setDocuments(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getStep(): Collection
    {
        return $this->Step;
    }

    public function addStep(Step $step): static
    {
        if (!$this->Step->contains($step)) {
            $this->Step->add($step);
            $step->setDocuments($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->Step->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getDocuments() === $this) {
                $step->setDocuments(null);
            }
        }

        return $this;
    }
}
