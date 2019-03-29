<?php

namespace EasyBlog\Controller;

use EasyBlog\Core\Controller;

class indexController extends Controller
{
    public function indexAction()
    {
        $twig = $this->getTwig();
        $model = $this->getModel();
        $limit = 100;
        $offset = 0;
        $articles = $model->getArticles($limit, $offset);
        $template = $twig->load('index');
        $context = $template->render(
            [
                'articles' => $articles,
            ]
        );
        echo $context;
    }

    public function searchAction()
    {
        $twig = $this->getTwig();
        $template = $twig->load('search');
        $kw = $this->getAttr()['kw'];
        $articles = false;
        if (!empty($kw)) {
            $model = $this->getModel();
            $articles = $model->search(['title' => $kw]);
        }
        $context = $template->render(
            [
                'articles' => $articles,
                'kw' => $kw
            ]
        );
        echo $context;
    }
}