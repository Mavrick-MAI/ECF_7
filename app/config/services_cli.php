<?php
declare(strict_types=1);

use Phalcon\Cli\Dispatcher;

/**
* Set the default namespace for dispatcher
*/
$di->setShared('dispatcher', function() {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('WebAppSeller\Modules\Cli\Tasks');
    return $dispatcher;
});
