<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use EddIriarte\Consumer\Action\FindConsumerWithAddress;
use Slim\App;
use Pimple\Psr11\Container;

return function (App $app) {
    /** @var Container $container */
    $container = $app->getContainer();

    $container['version'] = function ($c): string {
        $json = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json')
        );

        return $json->version;
    };

    $container[EntityManager::class] = function ($container): EntityManager {
        $doctrine = $container['settings']['doctrine'];
        
        $config = Setup::createAnnotationMetadataConfiguration(
            $doctrine['metadata_dirs'],
            $doctrine['dev_mode']
        );
    
        $config->setMetadataDriverImpl(
            new AnnotationDriver(
                new AnnotationReader,
                $doctrine['metadata_dirs']
            )
        );
    
        $config->setMetadataCacheImpl(
            new FilesystemCache(
                $doctrine['cache_dir']
            )
        );
    
        return EntityManager::create(
            $doctrine['connection'],
            $config
        );
    };

    $container[FindConsumerWithAddress::class] = function ($container) {
        return new FindConsumerWithAddress(
            $container->get(EntityManager::class)
        );
    };
};
