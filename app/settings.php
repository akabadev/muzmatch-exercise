<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            # Should be set to false in production
            'displayErrorDetails' => true, 

            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],

            'doctrine' => [
                # if true, metadata caching is forcefully disabled
                'dev_mode' => true,
                # path where the compiled metadata info will be cached
                # make sure the path exists and it is writable
                'cache_dir' => __DIR__ . '/var/doctrine',
                # path containing entity classes
                'metadata_dirs' => [__DIR__ . '/src/Domain'],
                'connection' => [
                    'driver' => 'pdo_mysql',
                    'host' => '127.0.0.1',
                    'port' => 3306,
                    'dbname' => 'muzmatch',
                    'user' => 'root',
                    'password' => 'root',
                ]
            ],
            
        ],
    ]);
};
