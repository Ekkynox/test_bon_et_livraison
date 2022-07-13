<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'catherine.p@gmail.com',
                'catherine',
                new DateTime('1978-10-31'),
                'Monaco'
            ],
            [
                'o.dubois@gmail.com',
                'dubois',
                new DateTime('2005-06-25'),
                'Villeurbanne'
            ],
        ];

        foreach ($users as $user) {
            $newUser = new User();
            $hashedPassword = $this->hasher->hashPassword($newUser, $user[1]);
            $newUser->setEmail($user[0])
                ->setPassword($hashedPassword)
                ->setBirthDate($user[2])
                ->setCity($user[3]);
            
            $manager->persist($newUser);
        }

        $manager->flush();
    }
}
