<?php

namespace EasyBlog\Core;

final class Bootstrap
{
    private $router;

    public static function run()
    {
        $instance = new self();
        $config = $instance->getRouteConfig();
        $instance->addRoute($config);
        $instance->disPath();
    }

    /**
     * @return Router|null
     */
    private function getRoute(): Router
    {
        if ($this->router === null) {
            $this->router = Router::getInstance();
        }
        return $this->router;
    }

    private function getRouteConfig()
    {
        return include Kernel::getConfig('route');
    }

    private function addRoute($configs)
    {
        $router = $this->getRoute();
        $map = $router->getMap();
        foreach ($configs as $config) {
            $method = $config['method'];
            foreach ($config['route'] as $name => $route) {
                if (is_array($route)) {
                    $map->$method($name, $route['route'])
                        ->tokens($route['tokens']);
                } else {
                    $map->$method($name, $route);
                }
            }
        }
    }

    private function disPath()
    {
        $router = $this->getRoute();
        $handler = $router->getHandler();
        $handler = empty($handler) ? 'index.index' : $handler;
        $handler = explode('.', $handler);
        $controllerClass = 'EasyBlog\\Controller\\' . $handler[0] . 'Controller';
        $action = $handler[1] . 'Action';
        $controller = new $controllerClass();
        $controller->$action();
    }
}