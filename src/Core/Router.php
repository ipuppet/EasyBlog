<?php

namespace EasyBlog\Core;

use Aura\Router\Map;
use Aura\Router\RouterContainer;
use Zend\Diactoros\ServerRequestFactory;

final class Router
{
    private $routerContainer;
    private $request;
    private $route;
    private $map;
    private $matcher;
    private static $instance;

    private function __construct()
    {
        $this->routerContainer = new RouterContainer();
        $this->request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }

    /**
     * 获取matcher实例
     */
    private function getMatcher()
    {
        if ($this->matcher === null)
            $this->matcher = $this->routerContainer->getMatcher();
        return $this->matcher;
    }

    /**
     * 匹配路由
     */
    private function match()
    {
        if ($this->route === null) {
            $matcher = $this->getMatcher();
            $this->route = $matcher->match($this->request);
            if (!$this->route) {
                // get the first of the best-available non-matched routes
                $failedRoute = $matcher->getFailedRoute();
                // which matching rule failed?
                $this->failedRule($failedRoute->failedRule);
                exit;
            } else {
                foreach ($this->route->attributes as $key => $val) {
                    $this->request = $this->request->withAttribute($key, $val);
                }
            }
        }
        return $this->route;
    }

    /**
     * 处理未能成功匹配的路由
     *
     * @param mixed $failedRoute 失败的路由
     */
    private function failedRule($failedRoute)
    {
        switch ($failedRoute) {
            case 'Aura\Router\Rule\Allows':
                // 405 METHOD NOT ALLOWED
                // Send the $failedRoute->allows as 'Allow:'
                break;
            case 'Aura\Router\Rule\Accepts':
                // 406 NOT ACCEPTABLE
                break;
            default:
                // 404 NOT FOUND
                header('HTTP/1.1 404 Not Found');
                header("status: 404 Not Found");
                echo '404';
                break;
        }
    }

    /**
     * 获取自身实例
     *
     * @return Router
     */
    public static function getInstance(): Router
    {
        if (self::$instance === null)
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * 获取Map
     *
     * @return Map
     */
    public function getMap():Map
    {
        if ($this->map === null)
            $this->map = $this->routerContainer->getMap();
        return $this->map;
    }

    /**
     * 获取路由传入的参数
     *
     * @return $this->match()->attributes
     */
    public function getAttr()
    {
        return $this->match()->attributes;
    }

    /**
     * 获取控制器和方法
     *
     * @return $this->match()->handler
     */
    public function getHandler()
    {
        return $this->match()->handler;
    }
}