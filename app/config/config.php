<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

$localConfiguration = [
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => '',
        'password' => '',
        'dbname'   => '',
        'charset'  => 'utf8',
    ]
];

$localConfigFileName = APP_PATH.'/config/local.php';
if(file_exists($localConfigFileName)) include 'local.php';
return new \Phalcon\Config([
    'version' => '1.0',

    'database' => [
        'adapter'  => $localConfiguration['database']['adapter'],
        'host'     => $localConfiguration['database']['host'],
        'username' => $localConfiguration['database']['username'],
        'password' => $localConfiguration['database']['password'],
        'dbname'   => $localConfiguration['database']['dbname'],
        'charset'  => $localConfiguration['database']['charset'],
    ],

    'application' => [
        'appDir'         => APP_PATH . '/',
        'modelsDir'      => APP_PATH . '/common/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/',
    ],

    /**
     * if true, then we print a new line at the end of each CLI execution
     *
     * If we dont print a new line,
     * then the next command prompt will be placed directly on the left of the output
     * and it is less readable.
     *
     * You can disable this behaviour if the output of your application needs to don't have a new line at end
     */
    'printNewLine' => true
]);
