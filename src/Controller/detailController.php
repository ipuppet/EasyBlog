<?php

namespace EasyBlog\Controller;

use EasyBlog\Core\Controller;

class detailController extends Controller
{
    //用来获取上下文章
    private function getContext($aid, $ifAdd, $maxId = 10000)
    {
        $model = $this->getModel();
        $newId = $ifAdd ? $aid + 1 : $aid - 1;
        if ($newId <= $maxId && $newId > 0) {
            $content = $model->getArticle($newId, 'aid,title');
        } else {
            $content['title'] = '没有啦~';
            $content['aid'] = '0';
        }
        if (empty($content)) {
            $result = $this->getContext($newId, $ifAdd, $maxId);
            if (mb_strlen($result['title']) > 8) {
                $result['title'] = mb_substr($result['title'], 0, 8) . '...';
            }
            return $result;
        }
        return $content;
    }

    public function showAction()
    {
        $twig = $this->getTwig();
        $model = $this->getModel();

        //获取参数
        $aid = $this->getAttr()['aid'];
        //获取文章
        $article = $model->getArticle($aid);
        //获取上下文章
        $previous = $this->getContext($aid, false);
        $maxId = $model->getLast()['aid'];
        $next = $this->getContext($aid, true, $maxId);
        //渲染模板
        $template = $twig->load('detail');
        $context = $template->render(
            [
                'article' => $article,
                'next' => $next,
                'previous' => $previous
            ]
        );
        echo $context;
    }

    public function aboutAction()
    {
        $twig = $this->getTwig();
        $template = $twig->load('about');
        $context = $template->render();
        echo $context;
    }
}