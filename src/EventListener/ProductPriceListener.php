<?php

namespace App\EventListener;

use App\Entity\Product;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Product::class)]
class ProductPriceListener
{

    public function preUpdate(PreUpdateEventArgs $event)
    {

        $oldPrice = $event->getOldValue('prix');
        $newPrice = $event->getNewValue('prix');

        dump($oldPrice);
        dump($newPrice);
    }
}

