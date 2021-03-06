<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
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
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Range(
     *      min = "-120 years",
     *      max = "now"
     * )
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
     * @ORM\OneToOne(targetEntity=AdminNote::class, cascade={"persist", "remove"})
     */
    private $adminNote;

    /**
     * @ORM\ManyToOne(targetEntity=JobSector::class, inversedBy="profiles")
     */
    private $jobSector;

    /**
     * @ORM\OneToMany(targetEntity=Application::class, mappedBy="profile")
     */
    private $applications;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="profile")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
        /**
         * Doctrine is not supposed to call the constructor when fetching from
         * the database. This provides a default and allows to only care about
         * changing updateAt on edits.
         */
        $now = new \DateTime();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }


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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
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

    /**
     * @return Collection|application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplications(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setProfile($this);
        }

        return $this;
    }

    public function removeApplications(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getProfile() === $this) {
                $application->setProfile(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFirstName() . $this->getLastName();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
