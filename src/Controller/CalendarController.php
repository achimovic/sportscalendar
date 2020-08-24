<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar/{name}/{year}", name="calendar")
     */
    public function index(Request $request, EntityManagerInterface $em, $name = 'default', $year = 2020)
    {
        /**
         * @var $repo EventRepository
         */
        $repo = $em->getRepository(Event::class);

        $events = $repo->findByYearAndCalendar($year, $name);

        return $this->render('calendar/index.html.twig', [
            'year' => $year,
            'name' => $name,
            'events' => $events
        ]);
    }
}
