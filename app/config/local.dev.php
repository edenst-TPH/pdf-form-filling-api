<?php

// Dev environment

return function (array $settings): array {
    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    $settings['error']['display_error_details'] = true;

    if (isset($_ENV['DOCKER']) ) {
        $settings['db']['host'] = 'postgres';
        $settings['db']['port'] = 5432;
        $settings['db']['username'] ='postgres';
        $settings['db']['password'] = $_ENV['DB_PASSWORD'] ?: 'password';
     }

    // Database
    //$settings['db']['database'] = 'pff_api_dev';

    return $settings;
};