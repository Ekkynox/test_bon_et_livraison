<?php

namespace App\Entity;

use App\Repository\ReservedTimeSlotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservedTimeSlotRepository::class)]
class ReservedTimeSlot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $timeslot;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservedTimeSlots')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToOne(inversedBy: 'reservedTimeSlot', targetEntity: Order::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $related_order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeslot(): ?\DateTimeInterface
    {
        return $this->timeslot;
    }

    public function setTimeslot(\DateTimeInterface $timeslot): self
    {
        $this->timeslot = $timeslot;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRelatedOrder(): ?Order
    {
        return $this->related_order;
    }

    public function setRelatedOrder(Order $related_order): self
    {
        $this->related_order = $related_order;

        return $this;
    }
}
