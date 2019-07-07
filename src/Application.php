<?php

namespace Application;

/**
 * Приложение
 *
 * Class Application
 * @package Application
 */
class Application
{
    /** @var Router  */
    private $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Запуск приложения
     */
    public function run()
    {
        $this->router->execute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    /**
     * Добавить роут с GET методом
     *
     * @param string $pattern
     * @param string $callback
     */
    public function get(string $pattern, string $callback)
    {
        $this->route($pattern, $callback, ['GET']);
    }

    /**
     * Добавить роут с POST методом
     *
     * @param string $pattern
     * @param string $callback
     */
    public function post(string $pattern, string $callback)
    {
        $this->route($pattern, $callback, ['POST']);
    }

    /**
     * Добавить роут с произвольным методом
     *
     * @param string $pattern
     * @param string $callback
     * @param array $methods
     */
    public function route(string $pattern, string $callback, array $methods)
    {
        $this->router->route($pattern, $callback, $methods);
    }
}