<?php
//ROOT_PATH用于指定域名后紧跟着的部分，如
//http://localhost:8000/ums/
//http://localhost:8000/ums/login
define('ROOT_PATH', '/EasyBlog');
return [
    [
        'method' => 'get',
        'route' => [
            '' => [
                'route' => ROOT_PATH . '/{page}',
                'tokens' => [
                    'page' => '[0-9]*'
                ]
            ],
            'index.search' => [
                'route' => ROOT_PATH . '/search/{kw}',
                'tokens' => [
                    'kw' => '.*'
                ]
            ],
            'detail.show' => ROOT_PATH . '/detail/{aid}',
            'classify.tag' => ROOT_PATH . '/tag/{tag}',
            'classify.archives' => ROOT_PATH . '/archives',
            'detail.about' => ROOT_PATH . '/about',

        ]
    ],
    //以下内容是admin模块的路由
    [
        'method' => 'get',
        'route' => [
            'admin.index' => ROOT_PATH . '/admin',
            'admin.login' => ROOT_PATH . '/admin/login',
            'admin.info' => ROOT_PATH . '/admin/info/{module}',
            'admin.articleList' => ROOT_PATH . '/admin/articleList',
            'admin.articleManager' =>
                [
                    'route' => ROOT_PATH . '/admin/articleManager/{aid}',
                    'tokens' => [
                        'aid' => '.*'
                    ]
                ],
        ]
    ], [
        'method' => 'post',
        'route' => [
            'admin.apiChangeInfo' => ROOT_PATH . '/admin/apiChangeInfo',
            'admin.apiLogin' => ROOT_PATH . '/admin/apiLogin',
            'admin.apiAddArticle' => ROOT_PATH . '/admin/apiAddArticle',
            'admin.apiChangeArticle' => ROOT_PATH . '/admin/apiChangeArticle',
            'admin.apiDeleteArticle' => ROOT_PATH . '/admin/apiDeleteArticle',
        ]
    ]
];