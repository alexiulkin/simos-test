<?php

namespace Application\Controller;

use Application\Helper\TemplateInterface;
use Application\Response\HtmlResponse;

class IndexController
{
    private $template;

    public function __construct(TemplateInterface $template)
    {
        $this->template = $template;

        $this->action();
    }

    private function action()
    {
        return new HtmlResponse($this->template->render('index'));
    }
}