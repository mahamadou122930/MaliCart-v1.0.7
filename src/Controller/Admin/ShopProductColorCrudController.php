<?php

namespace App\Controller\Admin;

use App\Entity\ShopProductColor;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ShopProductColorCrudController extends AbstractCrudController
{
  


    public static function getEntityFqcn(): string
    {
        return ShopProductColor::class;
    }


  

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ColorField::new('code'),

        ];
    }

}
