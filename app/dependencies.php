<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use UMA\DIC\Container;
use Doctrine\Common\Cache\FilesystemCache;

return function (ContainerBuilder $containerBuilder) {
    # Logger
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        }
    ]);
    # Doctrine
    $containerBuilder->addDefinitions([
        EntityManager::class => function (ContainerInterface $c): EntityManager {
            /** @var array $settings */
            $settings = $c->get('settings');
            
            $ormConfiguration = Setup::createAnnotationMetadataConfiguration(
                $settings['doctrine']['metadata_dirs'],
                $settings['doctrine']['dev_mode'],
                null,
                $settings['doctrine']['dev_mode'] ? null : new FilesystemCache($settings['doctrine']['cache_dir'])
            );

            return EntityManager::create(
                $settings['doctrine']['connection'],
                $ormConfiguration
            );
        },
    ]);

};
