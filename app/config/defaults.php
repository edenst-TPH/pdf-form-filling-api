<?php

// Application default settings

// Error reporting
error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Timezone
date_default_timezone_set('Europe/Berlin');

$settings = [];

// Error handler
$settings['error'] = [
    // Should be set to false for the production environment
    'display_error_details' => false,
];

// Logger settings
$settings['logger'] = [
    // Log file location
    'path' => __DIR__ . '/../logs',
    // Default log level
    'level' => \Psr\Log\LogLevel::DEBUG,
];

// Database settings
$settings['db'] = [

    'driver'=>'Cake\Database\Driver\Postgres',

    'host' => 'postgres',
    'port'  => 5432,
    'password' => 'password',
    'username' => 'postgres',
    'database' => 'postgres',

    'quoteIdentifiers' => true,
    'timezone' => null,
    'cacheMetadata' => false,
    'log' => false,
    'persistent' => false

    //  tbd: heck additional postgres configuration options

];

// Database migrations
$settings['phinx'] = [
    'paths' => [
        'migrations' => __DIR__ . '/../resources/migrations',
        'seeds' => __DIR__ . '/../resources/seeds',
    ],
    'default_migration_table' => 'phinxlog',
    'environments' => [
        'default_environment' => 'local',
        'version_order' => 'creation',
        'local' => [
            'adapter' => 'pgsql',
            'host' => 'postgres',
            'name' => 'postgres',
            'user' => 'postgres',
            'pass' => 'password',
            'charset' => 'utf8mb4',
        ],
    ],
];

// Twig settings
$settings['twig'] = [
    // Template paths
    'paths' => [
    __DIR__ . '/../templates',
    ],
    // Twig environment options
    'options' => [
    // Should be set to true in production
    'cache_enabled' => false,   #tbd, set to true in production
    'cache_path' => __DIR__ . '/../tmp/twig',
    ],
];

return $settings;
