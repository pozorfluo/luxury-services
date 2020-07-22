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

        $manager->persist($admin);

        $dev = new User();
        $dev->setEmail('d@ve.com');
        $dev->setRoles(['ROLE_ADMIN', 'ROLE_DEV']);
        $dev->setPassword($this->passwordEncoder->encodePassword(
            $dev,
            'devazerty'
        ));

        $manager->persist($dev);


        $manager->flush();
    }
}
