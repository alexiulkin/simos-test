<?php

namespace Application\Controller;

use Application\Helper\Filtration;
use Application\Helper\Mail;
use Application\Helper\Validation;

class ApiMailControllerFactory
{
    public function __invoke()
    {
        return new ApiMailController(
            new Filtration(),
            new Validation(),
            new Mail()
        );
    }
}