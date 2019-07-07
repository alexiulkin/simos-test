<?php

namespace Application;

/**
 * Роутинг
 *
 * Class Router
 * @package Application
 */
class Router
{
    /** @var array */
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Добавляем роут
     *
     * @param string $pattern
     * @param string $callback
     * @param array $methods
     */
    public function route(string $pattern, string $callback, array $methods)
    {
        $this->routes[$pattern] = [
            'callback'  => $callback,
            'methods'   => $methods
        ];
    }

    /**
     * Выполняем роут
     *
     * @param string $url
     * @param string $method
     * @return mixed
     */
    public function execute(string $url, string $method)
    {
        // выбрасываем исключение если в реквесте пустой HTTP метод
        if (empty($method)) {
            throw new Exception\InvalidArgumentException(
                'HTTP methods argument from request was empty'
            );
        }

        foreach ($this->routes as $pattern => $arr)
        {
            if ($pattern == $url && in_array($method, $arr['methods']))
            {
                $class = new $arr['callback'];
                return $class();
            }
        }

        // выбрасываем исключение если роут не найден
        throw new Exception\RuntimeException(sprintf(
            'Route "%s" not found',
            $url
        ));
    }
}