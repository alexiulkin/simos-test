<?php

use Application\Application;
use Application\Controller\ApiMailControllerFactory;
use Application\Controller\IndexControllerFactory;

return function (Application $app) : void {
    $app->get('/', IndexControllerFactory::class);
    $app->post('/api/mail', ApiMailControllerFactory::class);
};