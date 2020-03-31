<?php

// src/EventListener/SearchIndexerSubscriber.php
namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
// for Doctrine < 2.4: use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
// use App\Entity\Product;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

class EntityEventSubscriber implements EventSubscriber
{

    public function __construct(Security $security, EntityManager $em){
        $this->security = $security;
        $this->em = $em;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!($entity instanceof User)){
            $user = $this->security->getUser();
            $entity->setUpdatedBy($user);
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $user = $this->security->getUser();

        if (!($entity instanceof User)){
            $entity->setCreatedBy($user);
            $entity->setUpdatedBy($user);
        }
    }

    // public function index(LifecycleEventArgs $args)
    // {
    //     $entity = $args->getObject();

    //     // perhaps you only want to act on some "Product" entity
    //     if ($entity instanceof Product) {
    //         $entityManager = $args->getObjectManager();
    //         // ... do something with the Product
    //     }
    // }
}