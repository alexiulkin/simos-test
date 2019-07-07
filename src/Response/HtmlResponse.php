<?php

namespace Application\Response;

/**
 * Class HtmlResponse
 * @package Application\Response
 */
class HtmlResponse
{
    public function __construct(string $html)
    {
        $this->createBody($html);
    }

    private function createBody(string $html)
    {
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
        exit();
    }
}