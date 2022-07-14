<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToOne(mappedBy: 'related_order', targetEntity: ReservedTimeSlot::class, cascade: ['persist', 'remove'])]
    private $reservedTimeSlot;
    
    public function getId(): ?int
    {
        return $this->id;
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

    public function getReservedTimeSlot(): ?ReservedTimeSlot
    {
        return $this->reservedTimeSlot;
    }

    public function setReservedTimeSlot(ReservedTimeSlot $reservedTimeSlot): self
    {
        // set the owning side of the relation if necessary
        if ($reservedTimeSlot->getRelatedOrder() !== $this) {
            $reservedTimeSlot->setRelatedOrder($this);
        }

        $this->reservedTimeSlot = $reservedTimeSlot;

        return $this;
    }
}
