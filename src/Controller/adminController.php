<?php

namespace EasyBlog\Controller;

use EasyBlog\Core\Controller;

class adminController extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
        $handler = $this->getHandler();
        if (empty($_SESSION['admin']) && $handler !== 'admin.login' && $handler !== 'admin.apiLogin') {
            header("Location: /admin/login");
            return;
        } else {
            $this->addGlobalToTwig('admin', @$_SESSION['admin']);
        }
    }

    public function loginAction()
    {
        $twig = $this->getTwig();
        $template = $twig->load('login');
        $context = $template->render();
        echo $context;
    }

    public function indexAction()
    {
        $twig = $this->getTwig();
        $template = $twig->load('admin');
        $model = $this->getModel();
        $articles = $model->getArticles();
        $context = $template->render(
            [
                'articles' => $articles,
            ]
        );
        echo $context;
    }

    public function infoAction()
    {
        $twig = $this->getTwig();
        $model = $this->getModel();
        $template = $twig->load('info');
        $tags = $model->getTags();
        $banners = $model->getBanners();
        $context = $template->render(
            [
                'tags' => $tags,
                'banners' => $banners
            ]
        );
        echo $context;
    }

    public function articleManagerAction()
    {
        $twig = $this->getTwig();
        $template = $twig->load('articleManager');
        $article = 0;
        $aid = 0;
        if (!empty($this->getAttr()['aid']) && isset($this->getAttr()['aid'])) {
            $model = $this->getModel();
            $aid = $this->getAttr()['aid'];
            $article = $model->getArticle($aid);
        }
        $context = $template->render(
            [
                'article' => $article,
                'aid' => $aid
            ]
        );
        echo $context;
    }

    /*
     * 数据处理类方法
     * */

    public function apiLoginAction()
    {
        $model = $this->getModel();
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        $result = $model->tryLoginAdmin($username, $password);
        if (is_bool($result) && $result) {
            $_SESSION['admin']['username'] = $username;
            echo '{"state":"1"}';
        } else {
            echo '{"state":"0","msg":"' . $result . '"}';
        }
    }

    public function apiChangeInfoAction()
    {
        $model = $this->getModel();
        $data = filter_input(INPUT_POST, 'data');
        $name = filter_input(INPUT_POST, 'name');
        $dataArr = json_decode($data, true);
        $updateAction = 'update' . ucfirst($name);
        $result = $model->$updateAction($dataArr);
        if ($result)
            echo '{"state":"1"}';
        else
            echo '{"state":"0"}';
    }

    public function apiAddArticleAction()
    {
        $model = $this->getModel();
        $title = filter_input(INPUT_POST, 'title');
        $tags = filter_input(INPUT_POST, 'tags');
        $original = filter_input(INPUT_POST, 'original');
        $html = filter_input(INPUT_POST, 'html');
        $html = htmlentities($html, ENT_QUOTES, 'UTF-8');
        $result = $model->addArticle($title, $original, $html, $tags);
        if ($result)
            echo '{"state":"1"}';
        else
            echo '{"state":"0"}';
    }

    public function apiChangeArticleAction()
    {
        $model = $this->getModel();
        $aid = filter_input(INPUT_POST, 'aid');
        $title = filter_input(INPUT_POST, 'title');
        $tags = filter_input(INPUT_POST, 'tags');
        $original = filter_input(INPUT_POST, 'original');
        $html = filter_input(INPUT_POST, 'html');
        $html = htmlentities($html, ENT_QUOTES, 'UTF-8');
        $data = [
            'title' => $title,
            'original' => $original,
            'content' => $html,
            'tags' => $tags,
            'lastChangeDate' => date('Y-m-d H:i:s')
        ];
        $result = $model->updateArticle($data, $aid);
        if ($result)
            echo '{"state":"1"}';
        else
            echo '{"state":"0"}';
    }

    public function apiDeleteArticleAction()
    {
        $model = $this->getModel();
        $aid = filter_input(INPUT_POST, 'aid');
        $result = $model->deleteArticle($aid);
        if ($result)
            echo '{"state":"1"}';
        else
            echo '{"state":"0"}';
    }
}