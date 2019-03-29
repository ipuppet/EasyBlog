<?php

namespace EasyBlog\Controller;

use EasyBlog\Core\Controller;

class classifyController extends Controller
{
    public function tagAction()
    {
        $twig = $this->getTwig();
        $model = $this->getModel();

        $tag = $this->getAttr()['tag'];
        $articles = $model->search(['tags' => $tag]);
        $template = $twig->load('tag');
        $context = $template->render(
            [
                'articles' => $articles,
                'tag' => $tag
            ]
        );
        echo $context;
    }

    public function archivesAction()
    {
        $twig = $this->getTwig();
        $model = $this->getModel();

        $articles = $model->getArticles();
        foreach ($articles as $key => $article) {
            //分离日期和时间
            $arr = explode(' ', $article['creatDate']);
            $data = $arr[0];
            $creatDate = $arr[1];
            $dataArr = explode('-', $data);
            $articles[$key]['creatDate'] = $creatDate;
            $articles[$key]['year'] = $dataArr[0];
            $articles[$key]['mouth'] = $dataArr[1];
            $articles[$key]['day'] = $dataArr[2];
        }
        $template = $twig->load('archives');
        $context = $template->render(
            [
                'articles' => $articles
            ]
        );
        echo $context;
    }
}