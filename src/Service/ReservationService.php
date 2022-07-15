<?php

namespace App\Service;

use App\Entity\ReservedTimeSlot;
use App\Repository\OrderRepository;
use App\Repository\ReservedTimeSlotRepository;
use DateInterval;
use DateTime;
use Exception;

class ReservationService
{
    private ReservedTimeSlotRepository $reservedRepo;
    private OrderRepository $orderRepo;

    public function __construct(ReservedTimeSlotRepository $reservedRepo, OrderRepository $orderRepo)
    {
        $this->reservedRepo = $reservedRepo;
        $this->orderRepo = $orderRepo;
    }

    /**
     * retourne la disponiblité d'un horaire sous forme de booléen
     */
    public function isAvailableTimeSlot(DateTime $slot) :bool
    {
        $reserved = $this->reservedRepo->findOneBy([ 'timeslot' => $slot]);
        if ($reserved == false) {
            return true;
        } else {
            return false;
        }
    }

    public function reserveTimeSlot(DateTime $timeslot, int $orderId)
    {
        $order = $this->orderRepo->findOneBy(['id' => $orderId ]);

        if(!$order) {
            return [
                'message' => "Cette commande n'existe pas",
                'code' => 409
            ];
        }

        $timeslotToReserve = new ReservedTimeSlot();
        $timeslotToReserve->setTimeslot($timeslot)->setRelatedOrder($order);

        //on vérifie que la commande n'a pas déjà une date de livraison
        if($timeslotToReserve->getRelatedOrder()->getReservedTimeSlot()) {
            return [
                'message' => "Cette commande a déjà un horaire de livraison.",
                'code' => 409
            ];
        };

        //on vérifie que la date est bien dans les deux jours suivant la commande
        $limitDate = clone $timeslotToReserve->getRelatedOrder()->getDate();
        $limitDate->add(new DateInterval("P2D"));
        if(new DateTime() < $timeslotToReserve->getTimeslot() && $timeslotToReserve->getTimeslot() < $limitDate) {
            
        } else {
            return [
                'message' => "La livraison ne peut se faire que dans les deux jours après la commande.",
                'code' => 409
            ];
        }

        //on vérifie la disponibilité de l'horaire
        if (!$this->isAvailableTimeSlot($timeslotToReserve->getTimeSlot())) {
            return [
                'message' => "Cet horaire est déjà réservé.",
                'code' => 409
            ];
        }
        
        $this->reservedRepo->add($timeslotToReserve, true);
            return [
                'message' => "Ok.",
                'code' => 200
            ];
    }
}