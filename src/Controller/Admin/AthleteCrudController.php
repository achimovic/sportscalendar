<?php

namespace App\Controller\Admin;

use App\Entity\Athlete;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AthleteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Athlete::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('teams')
        ];
    }
}
