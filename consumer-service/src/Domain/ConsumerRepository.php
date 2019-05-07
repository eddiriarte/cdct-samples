<?php

namespace EddIriarte\Consumer\Entity;

use Doctrine\ORM\EntityManager;

class ConsumerRepository
{
    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function findUserWithAddress(string $consumerId, $addressId)
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select(['c', 'a'])
            ->from('Consumer', 'c')
            ->leftJoin('Address', 'a')
            ->where('c.id = :consumerId')
            ->andWhere('a.id = :addressId')
            ->orderBy('c.name', 'ASC')
            ->setParameter('consumerId', $consumerId)
            ->setParameter('addressId', $addressId);

        $query = $queryBuilder->getQuery();

        $results = $query->getResult();

        return $results;
    }
    
}
