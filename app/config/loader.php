<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'Test1\Models' => APP_PATH . '/common/models/',
    'Test1'        => APP_PATH . '/common/library/',
]);

/**
 * Register module classes
 */
$loader->registerClasses([
    'Test1\Modules\Frontend\Module' => APP_PATH . '/modules/frontend/Module.php',
    'Test1\Modules\Cli\Module'      => APP_PATH . '/modules/cli/Module.php'
]);

$loader->register();
