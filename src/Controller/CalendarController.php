<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar/{year}", name="calendar")
     */
    public function index(Request $request, EntityManagerInterface $em, $year = null)
    {
        $qb = $em->createQueryBuilder();

        $events = $qb->select('Event')
            ->from(Event::class, 'Event')
            ->andWhere('Event.start >= :start')
            ->andWhere('Event.start < :end')
            ->setParameter('start', new \DateTime($year . '-01-01 00:00:00'))
            ->setParameter('end', new \DateTime($year + 1 . '-01-01 00:00:00'))
            ->getQuery()
            ->getResult()
        ;

        return $this->render('calendar/index.html.twig', [
            'year' => $year,
            'events' => $events
        ]);
    }
}
