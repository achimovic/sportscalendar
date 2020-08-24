<?php

namespace App\Controller\Admin;

use App\Entity\Athlete;
use App\Entity\Calendar;
use App\Entity\Event;
use App\Entity\League;
use App\Entity\Sport;
use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(CalendarCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sportscalendar');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Calendar', 'fa fa-calendar', Calendar::class);
        yield MenuItem::linkToCrud('Event', 'fa fa-calendar-o', Event::class);
        yield MenuItem::linkToCrud('League', 'fa fa-trophy', League::class);
        yield MenuItem::linkToCrud('Sport', 'fa fa-futbol-o', Sport::class);
        yield MenuItem::linkToCrud('Team', 'fa fa-users', Team::class);
        yield MenuItem::linkToCrud('Athlete', 'fa fa-user', Athlete::class);
    }
}
