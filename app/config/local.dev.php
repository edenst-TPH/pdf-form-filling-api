<?php

// Dev environment

return function (array $settings): array {
    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    $settings['error']['display_error_details'] = true;

    if (isset($_ENV['DOCKER']) && $_ENV['DOCKER'] === 'local' ) {
        $settings['db']['host'] = $_ENV['DB_HOST'] ?: 'postgres';
        $settings['db']['port'] = $_ENV['DB_PORT'] ?: 5432;
        $settings['db']['username'] = $_ENV['DB_USER'] ?: 'postgres';
        $settings['db']['password'] = $_ENV['DB_PASSWORD'] ?: 'password';
     }

    // Database
    //$settings['db']['database'] = 'pff_api_dev';

    return $settings;
};