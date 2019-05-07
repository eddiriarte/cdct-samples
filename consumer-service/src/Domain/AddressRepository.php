<?php

namespace EddIriarte\Consumer\Entity;

use Doctrine\ORM\EntityManager;

class AddressRepository
{
    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    
}
