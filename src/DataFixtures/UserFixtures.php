<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        

        $user = new User();
        $user->setEmail('nos@gmail.com');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'tekilatex'
        ));
        $user->setFirstName('Nicolas');
        $user->setLastName('Klipfel');
        $user->setSlug(uniqid($user->getFirstName()));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
