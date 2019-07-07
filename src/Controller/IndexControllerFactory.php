<?php

namespace Application\Controller;

use Application\Helper\Template;

class IndexControllerFactory
{
    public function __invoke()
    {
        return new IndexController(
            new Template()
        );
    }
}