<?php

namespace EddIriarte\Consumer\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;

class GetApplicationVersion
{
    /**
     * @var string
     */
    private $version;

    public function __construct(ContainerInterface $container)
    {
        $this->version = $container->get('version');
    }

    /**
     * Gets the current application version.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return void
     */
    public function __invoke($request, $response, $args)
    {
        return $response->withJson(
            "Consumer Service ({$this->version}) powered by Slim"
        );
    }
}
