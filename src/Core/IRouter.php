<?php


namespace EasyBlog\Core;


interface IRouter
{
    /**
     * 添加路由
     *
     * @param array $routes 详细路由信息
     */
    public function addRoute(array $routes);

    /**
     * 获取路由传入的参数
     *
     * @return array
     */
    public function getAttr();

    /**
     * 获取控制器和方法
     *
     * @return string
     */
    public function getHandler();
}