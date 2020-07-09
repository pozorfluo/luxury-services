<?php

namespace App\Entity;

use App\Repository\AdminNoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminNoteRepository::class)
 */
class AdminNote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $files = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=Profile::class, mappedBy="adminNote", cascade={"persist", "remove"})
     */
    private $target;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(?array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTarget(): ?Profile
    {
        return $this->target;
    }

    public function setTarget(?Profile $target): self
    {
        $this->target = $target;

        // set (or unset) the owning side of the relation if necessary
        $newAdminNote = null === $target ? null : $this;
        if ($target->getAdminNote() !== $newAdminNote) {
            $target->setAdminNote($newAdminNote);
        }

        return $this;
    }
}
