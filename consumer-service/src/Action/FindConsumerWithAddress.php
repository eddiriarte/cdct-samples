<?php

namespace EddIriarte\Consumer\Action;


use Doctrine\ORM\EntityManager;
use EddIriarte\Consumer\Entity\Consumer;
use Slim\Http\Request;
use Slim\Http\Response;

class FindConsumerWithAddress
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(Request $request, Response $response)
    {
        $consumerId = $request->getParam('consumerId');
        $addressId = $request->getParam('addressId');

        $consumer = $this->entityManager
            ->getRepository(Consumer::class)
            ->findBy(
                [
                    'id' => $consumerId
                ]
            );
//            ->findUserWithAddress($consumerId, $addressId);

        $response->withJson($consumer);
    }
}