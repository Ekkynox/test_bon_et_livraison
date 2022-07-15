<?php

namespace App\DataTransfertObjects;

use DateTime;

class ReservationRequest {

    private DateTime $timeslot;
    private int $orderId;


    /**
     * Get the value of timeslot
     */ 
    public function getTimeslot()
    {
        return $this->timeslot;
    }

    /**
     * Set the value of timeslot
     *
     * @return  self
     */ 
    public function setTimeslot($timeslot)
    {
        $this->timeslot = $timeslot;

        return $this;
    }

    /**
     * Get the value of orderId
     */ 
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId
     *
     * @return  self
     */ 
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }
}