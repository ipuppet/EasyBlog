<?php

//composer的psr-4自动加载器
require dirname(__DIR__) . '/vendor/autoload.php';
//加载核心代码
require dirname(__DIR__) . '/app/Kernel.php';
//设置whoops提供的错误和异常处理程序
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//启动项目
\EasyBlog\Core\Bootstrap::run();
