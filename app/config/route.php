<?php

return [
    [
        'method' => 'get',
        'route' => [
            '' => [
                'route' => '/{page}',
                'tokens' => [
                    'page' => '.*'
                ]
            ],
            'index.search' => [
                'route' => '/search/{kw}',
                'tokens' => [
                    'kw' => '.*'
                ]
            ],
            'detail.show' => '/detail/{aid}',
            'classify.tag' => '/tag/{tag}',
            'classify.archives' => '/archives',
            'detail.about' => '/about',

        ]
    ],
    //以下内容是admin模块的路由
    [
        'method' => 'get',
        'route' => [
            'admin.index' => '/admin',
            'admin.login' => '/admin/login',
            'admin.info' => '/admin/info',
            'admin.articleManager' =>
                [
                    'route' => '/admin/articleManager/{aid}',
                    'tokens' => [
                        'aid' => '.*'
                    ]
                ],
        ]
    ], [
        'method' => 'post',
        'route' => [
            'admin.apiChangeInfo' => '/admin/apiChangeInfo',
            'admin.apiLogin' => '/admin/apiLogin',
            'admin.apiAddArticle' => '/admin/apiAddArticle',
            'admin.apiChangeArticle' => '/admin/apiChangeArticle',
            'admin.apiDeleteArticle' => '/admin/apiDeleteArticle',
        ]
    ]
];