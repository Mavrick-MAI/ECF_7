<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'WebAppSeller\Models' => APP_PATH . '/common/models/',
    'WebAppSeller'        => APP_PATH . '/common/library/',
]);

/**
 * Register module classes
 */
$loader->registerClasses([
    'WebAppSeller\Modules\Frontend\Module' => APP_PATH . '/modules/frontend/Module.php',
    'WebAppSeller\Modules\Cli\Module'      => APP_PATH . '/modules/cli/Module.php'
]);

$loader->register();
