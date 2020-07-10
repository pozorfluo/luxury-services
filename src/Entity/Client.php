<?php

namespace App\Entity;

use App\Entity\AnnotatedItem;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client extends AnnotatedItem
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
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactPosition;

    /**
     * @ORM\OneToOne(targetEntity=AdminNote::class, inversedBy="client", cascade={"persist", "remove"})
     */
    private $adminNote;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactPosition(): ?string
    {
        return $this->contactPosition;
    }

    public function setContactPosition(?string $contactPosition): self
    {
        $this->contactPosition = $contactPosition;

        return $this;
    }

    public function getAdminNote(): ?AdminNote
    {
        return $this->adminNote;
    }

    public function setAdminNote(?AdminNote $adminNote): self
    {
        $this->adminNote = $adminNote;

        return $this;
    }
}
