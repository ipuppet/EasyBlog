<?php

namespace EasyBlog\Core;

final class Bootstrap
{
    private $router;

    public static function run()
    {
        $instance = new self();
        $config = $instance->getRouteConfig();
        $instance->getRoute()->addRoute($config);
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