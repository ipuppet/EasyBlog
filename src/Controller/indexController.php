<?php

namespace EasyBlog\Controller;

use EasyBlog\Core\Controller;

class indexController extends Controller
{
    public function indexAction()
    {
        $twig = $this->getTwig();
        $model = $this->getModel();
        $page = isset($this->getAttr()['page']) ? $this->getAttr()['page'] : 1;
        $result = $model->paging(3, $page);
        $template = $twig->load('index');
        $context = $template->render(
            [
                'articles' => $result['articles'],
                'page' => $page,
                'pageCount' => $result['pageCount']
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