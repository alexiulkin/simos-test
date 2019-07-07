<?php

namespace Application\Response;

/**
 * Class JsonResponse
 * @package Application\Response
 */
class JsonResponse
{
    public function __construct(array $data)
    {
        $this->createBody($data);
    }

    private function createBody(array $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit();
    }
}