<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 */
class Application
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(
     *   targetEntity=Profile::class,
     *   inversedBy="applications",
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $profile;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(
     *   targetEntity=Job::class,
     *   inversedBy="applicants",
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $job;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        /**
         * Doctrine is not supposed to call the constructor when fetching from
         * the database. This provides a default and allows to only care about
         * changing updateAt on edits.
         */
        $this->createdAt = new \DateTime();
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

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
}
