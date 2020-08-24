<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @param int $year
     * @param string $calendarTitle
     * @return Event[]
     */
    public function findByYearAndCalendar($year, $calendarTitle)
    {
        return $this->createQueryBuilder('e')
            ->select('Event, Team, Athlete, League, Sport')
            ->from(Event::class, 'Event')
            ->join('Event.calendars', 'Calendar')
            ->leftJoin('Event.teams', 'Team')
            ->leftJoin('Event.athletes', 'Athlete')
            ->leftJoin('Event.sport', 'Sport')
            ->leftJoin('Event.league', 'League')
            ->andWhere('Event.start >= :start')
            ->andWhere('Event.start < :end')
            ->andWhere('Calendar.name = :calendar')
            ->setParameter('start', new \DateTime($year . '-01-01 00:00:00'))
            ->setParameter('end', new \DateTime($year + 1 . '-01-01 00:00:00'))
            ->setParameter('calendar', $calendarTitle)
            ->orderBy('Event.start', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
