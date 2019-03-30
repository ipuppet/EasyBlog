<?php

namespace EasyBlog\Core;

//导入Monolog的命名空间
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Exception;

class Kernel
{
    public static function newLogs($name)
    {
        //设置Monolog提供的日志记录器
        $log = new Logger($name);
        try {
            $log->pushHandler(new StreamHandler(
                    Kernel::getLogDir() . "/{$name}.log", Logger::WARNING)
            );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $log;
    }

    public static function getRootDir()
    {
        return __DIR__;
    }

    public static function getConfig($config)
    {
        if (strpos($config, '.json') !== false)
            return Kernel::getRootDir() . '/config/' . $config;
        else
            return Kernel::getRootDir() . '/config/' . $config . '.php';
    }

    public static function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache';
    }

    public static function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }
}