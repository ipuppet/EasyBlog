<?php

namespace EasyBlog\Core;

use Twig\TemplateWrapper;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use \Monolog\Logger;
use Exception;

final class WrapTwig
{
    private $twig;
    private $config;
    private $log;
    private static $instance;

    /**
     * 构造函数，生成twig实例存放到$this->twig
     *
     * @param mixed $templates 模板路径
     * @param bool $debug 是否开启debug
     */
    private function __construct($templates = null, bool $debug = false)
    {
        //加载配置文件
        $this->config = include Kernel::getConfig('twig');
        if (isset($this->config['debug']))
            $debug = $this->config['debug'];
        //判断模板文件夹路径
        if ($templates === null) {
            if (is_array($this->config['templates'])) {
                foreach ($this->config['templates'] as $template) {
                    $templates[] = Kernel::getRootDir() . $template;
                }
            } else {
                $templates = Kernel::getRootDir() . $this->config['templates'];
            }
        }
        try {
            $loader = new FilesystemLoader($templates);
            $this->twig = new Environment($loader, array(
                'cache' => Kernel::getCacheDir(),
                'debug' => $debug,
                'auto_reload' => $debug,
            ));
        } catch (Exception $e) {
            $mse = $e->getMessage();
            $code = $e->getCode();
            $this->getLog()->addError("{$mse} Error code: {$code}");
        }
    }

    /**
     * 初始化Monolog
     *
     * @return  Logger monolog实例
     */
    private function getLog(): Logger
    {
        //初始化Monolog
        if ($this->log === null)
            $this->log = Kernel::newLogs('twig');
        return $this->log;
    }

    /**
     * 获取正确的模板名
     *
     * @param string $name 模板名
     *
     * @return string $name 正确的模板名
     */
    private function getTemplateName(string $name): string
    {
        if (substr($name, -strlen($this->config['suffix'])) !== $this->config['suffix'])
            $name = $name . $this->config['suffix'];
        return $name;
    }

    /**
     * 取得实例
     *
     * @param string $templates 模板路径
     * @param bool $debug 是否开启debug
     *
     * @return WrapTwig 自身实例
     */
    public static function getInstance($templates = null, bool $debug = false): WrapTwig
    {
        if (self::$instance === null)
            self::$instance = new self($templates, $debug);
        return self::$instance;
    }

    /**
     * 加载模板
     *
     * @param string $templateName 模板名
     *
     * @return TemplateWrapper $template $template实例
     */
    public function load(string $templateName): TemplateWrapper
    {
        $template = null;
        try {
            $template = $this->twig->load($this->getTemplateName($templateName));
        } catch (Exception $e) {
            $mse = $e->getMessage();
            $code = $e->getCode();
            $this->getLog()->addError("{$mse} Error code: {$code}");
        }
        return $template;
    }

    /**
     * 添加全局数据
     *
     * @param string $name 变量名
     * @param mixed $var 变量值
     */
    public function addGlobal(string $name, $var)
    {
        $this->twig->addGlobal($name, $var);
    }
}