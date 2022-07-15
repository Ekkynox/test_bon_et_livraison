<?php

namespace App\DataTransfertObjects;

use DateTime;

class CheckDiscountRequest
{
    private string $code;
    private string $userCity;
    private DateTime $userBirthDate;

    /**
     * Get the value of userBirthDate
     */ 
    public function getUserBirthDate()
    {
        return $this->userBirthDate;
    }

    /**
     * Set the value of userBirthDate
     *
     * @return  self
     */ 
    public function setUserBirthDate($userBirthDate)
    {
        $this->userBirthDate = $userBirthDate;

        return $this;
    }

    /**
     * Get the value of userCity
     */ 
    public function getUserCity()
    {
        return $this->userCity;
    }

    /**
     * Set the value of userCity
     *
     * @return  self
     */ 
    public function setUserCity($userCity)
    {
        $this->userCity = $userCity;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}