<?php

namespace App\DataFixtures;

use App\Entity\DiscountCode;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DiscountCodeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $codes = [
            [
                'VIVELESVACANCES2022',
                new DateTime('2022-06-07'),
                new DateTime('2022-03-09'),
                null,
                null,
                null,
            ],
            [
                'ETUDIANT23',
                new DateTime('2022-03-07'),
                new DateTime('2022-01-12'),
                null,
                23,
                null,
            ],
            [
                'ONLYMONACO',
                new DateTime('2022-11-09'),
                null,
                null,
                null,
                'Monaco',
            ],
            [
                'VILLEURBANNEENFLEUR',
                null,
                null,
                null,
                null,
                'Villeurbanne',
            ],
        ];

        foreach ($codes as $code) {
            $newDiscount = new DiscountCode();
            $newDiscount->setCode($code[0])
                ->setFromDate($code[1])
                ->setToDate($code[2])
                ->setAgeMin($code[3])
                ->setAgeMax($code[4])
                ->setCity($code[5]);

            $manager->persist($newDiscount);
        }

        $manager->flush();
    }
}
