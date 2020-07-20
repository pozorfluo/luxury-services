<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('moul@ga.com');

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            '!dummy_password!'
        ));
        $user->setUpdatedAt($user->getCreatedAt());

        $admin = new User();
        $admin->setEmail('admin@luxury-service.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            '!dummy_password!'
        ));
        $admin->setUpdatedAt($user->getCreatedAt());

        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();
    }
}
