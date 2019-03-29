<?php

namespace EasyBlog\Core;

class Controller
{
    private $route;
    private $model;
    private $twig;

    public function __construct()
    {
        $this->addGlobalToTwig();
    }

    /**
     * 将数据存放至twig的全局变量中
     */
    private function addGlobalToTwig()
    {
        $twig = $this->getTwig();
        $model = $this->getModel();
        //添加的数据
        $twig->addGlobal('about', $model->getAbout());
        $twig->addGlobal('banners', $model->getBanners());
        $twig->addGlobal('tags', $model->getTags());
    }

    /**
     * 获取数据操作类实例
     *
     * @return Model
     */
    protected function getModel(): Model
    {
        if ($this->model === null)
            $this->model = new Model();
        return $this->model;
    }

    /**
     * 获取路由传入的参数
     *
     * @return Router->match()->attributes
     */
    protected function getAttr()
    {
        if ($this->route === null)
            $this->route = Router::getInstance();
        return $this->route->getAttr();
    }

    /**
     * 获取控制器和方法
     *
     * @return Router->match()->handler
     */
    protected function getHandler()
    {
        if ($this->route === null)
            $this->route = Router::getInstance();
        return $this->route->getHandler();
    }

    /**
     * 获取封装后的twig模板引擎实例
     *
     * @param string $templates 模板路径
     * @param bool $debug debug
     *
     * @return WrapTwig
     */
    protected function getTwig($templates = null, $debug = false): WrapTwig
    {
        if ($this->twig === null)
            $this->twig = WrapTwig::getInstance($templates, $debug);
        return $this->twig;
    }
}