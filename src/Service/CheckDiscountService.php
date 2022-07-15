<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\DiscountCodeRepository;
use DateTime;

class CheckDiscountService
{
    private $discountRepo;

    public function __construct(DiscountCodeRepository $discountRepo)
    {
        $this->discountRepo = $discountRepo;
    }

    /**
    * retourne un tableau de deux éléments : la validité (valid) sous forme de booléen et les erreurs (errors) sous forme de tableau
    */
    public function checkDiscount(string $codeToVerify, string $city, DateTime $birthdate) {

        $code = $this->discountRepo->findOneBy(['code' => $codeToVerify]);
        $errors = [];

        if($code) {
            $date = new DateTime();
            if ($code->getFromDate() && $code->getFromDate() >= $date) $errors[] = 'Ce code promo n\'est pas encore valide.';
            if ($code->getToDate() && $code->getToDate() >= $date) $errors[] = 'Ce code promo n\'est plus valide.';
            if ($code->getAgeMin() && $code->getAgeMin() >= $birthdate->diff(new DateTime())->y || $code->getAgeMax() && $code->getAgeMax() <= $birthdate->diff(new DateTime())->y) $errors[] = 'Vous n\'avez pas l\'âge requis pour utiliser ce code.';
            if ($code->getCity() && $code->getCity() != $city) $errors[] = 'Ce code promo n\'est valide que pour les habitants de ' . $code->getCity() . '.';
        } else {
            $errors[] = 'Ce code promo n\'existe pas.';
        }

        return ['valid' => empty($errors), 'errors' => $errors];
    }
}