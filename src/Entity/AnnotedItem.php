<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *   "client"  = "Client",
 *   "profile" = "Profile"
 * })
 */
class AnnotatedItem
{
    // public function getAdminNote(): ?AdminNote;

    // public function setAdminNote(?AdminNote $adminNote): self;
}
