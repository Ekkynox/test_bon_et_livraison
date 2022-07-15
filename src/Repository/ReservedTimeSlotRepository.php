<?php

namespace App\Repository;

use App\Entity\ReservedTimeSlot;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservedTimeSlot>
 *
 * @method ReservedTimeSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservedTimeSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservedTimeSlot[]    findAll()
 * @method ReservedTimeSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservedTimeSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservedTimeSlot::class);
    }

    public function add(ReservedTimeSlot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReservedTimeSlot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return ReservedTimeSlot[] retourne les réservations entre deux dates
    */
    public function findReservedSlots(DateTime $from, DateTime $to): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.timeslot BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?ReservedTimeSlot
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
