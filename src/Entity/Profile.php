<?php

namespace App\Entity;

use App\Entity\AnnotatedItem;
use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile extends AnnotatedItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nationality;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasPassport;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passportScan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $curriculumVitae;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currentLocation;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $placeOfBirth;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToOne(targetEntity=AdminNote::class, inversedBy="target", cascade={"persist", "remove"})
     */
    private $adminNote;

    /**
     * @ORM\ManyToOne(targetEntity=JobSector::class, inversedBy="profiles")
     */
    private $jobSector;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getHasPassport(): ?bool
    {
        return $this->hasPassport;
    }

    public function setHasPassport(?bool $hasPassport): self
    {
        $this->hasPassport = $hasPassport;

        return $this;
    }

    public function getPassportScan(): ?string
    {
        return $this->passportScan;
    }

    public function setPassportScan(?string $passportScan): self
    {
        $this->passportScan = $passportScan;

        return $this;
    }

    public function getCurriculumVitae(): ?string
    {
        return $this->curriculumVitae;
    }

    public function setCurriculumVitae(?string $curriculumVitae): self
    {
        $this->curriculumVitae = $curriculumVitae;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCurrentLocation(): ?string
    {
        return $this->currentLocation;
    }

    public function setCurrentLocation(?string $currentLocation): self
    {
        $this->currentLocation = $currentLocation;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeImmutable $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): self
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getExperience(): ?\DateInterval
    {
        return $this->experience;
    }

    public function setExperience(?\DateInterval $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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

    public function getJobSector(): ?JobSector
    {
        return $this->jobSector;
    }

    public function setJobSector(?JobSector $jobSector): self
    {
        $this->jobSector = $jobSector;

        return $this;
    }
}
