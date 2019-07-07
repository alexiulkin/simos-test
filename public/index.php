<?php

chdir(dirname(__DIR__));
require 'autoload.php';

(function () {
    $app = new \Application\Application();

    (require 'config/routes.php')($app);

    $app->run();
})();