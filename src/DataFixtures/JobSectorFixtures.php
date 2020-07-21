<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\JobSector;

class JobSectorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sectors = [
            'Commercial',
            'Retail sales',
            'Creative',
            'Technology',
            'Marketing & PR',
            'Fashion & Luxury',
            'Management & HR',
        ];
        foreach ($sectors as $sector) {
            $jobSector = new JobSector();
            $jobSector->setName($sector);
            $manager->persist($jobSector);
        }

        $manager->flush();
    }
}
