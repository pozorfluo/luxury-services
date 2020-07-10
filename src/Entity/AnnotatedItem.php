<?php

namespace App\Entity;

// use App\Entity\Job;
// use App\Entity\Client;
// use App\Entity\Profile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *   "client"  = "Client",
 *   "profile" = "Profile",
 *   "job" = "Job"
 * })
 */
abstract class AnnotatedItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    // public function getAdminNote(): ?AdminNote;

    // public function setAdminNote(?AdminNote $adminNote): self;
}
