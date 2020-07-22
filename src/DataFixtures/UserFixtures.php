<?php

namespace App\DataFixtures;

use App\Entity\Profile;
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
            'azertyui'
        ));
        $user->setUpdatedAt($user->getCreatedAt());
        $profile = new Profile();
        $profile->setFirstName('Moula')
            ->setLastName('Ga');
        $user->setProfile($profile);
        $manager->persist($user);
        $manager->persist($profile);


        $admin = new User();
        $admin->setEmail('admin@luxury-service.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            '!dummy_password!'
        ));
        $admin->setUpdatedAt($user->getCreatedAt());

        $manager->persist($admin);
        $manager->flush();
    }
}
