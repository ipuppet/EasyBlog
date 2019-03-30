<?php

namespace EasyBlog\Core;

use EasyBlog\Ext\htmlSecuritySplit;

class Model
{
    private $data;
    private $pdo;

    /**
     * 获取pdo实例
     *
     * @return WrapPdo
     */
    private function getPdo(): WrapPdo
    {
        if ($this->pdo === null)
            $this->pdo = WrapPdo::getInstance();
        return $this->pdo;
    }

    /**
     * 获取data.json中的数据
     *
     * @return array $this->data data.json中的数据
     */
    private function getData(): array
    {
        if ($this->data === null) {
            $json = file_get_contents(Kernel::getConfig('data.json'));
            $this->data = json_decode($json, true);
        }
        return $this->data;
    }

    /**
     * 后台管理登陆验证
     *
     * @param string $username
     * @param string $password
     *
     * @return mixed 成功返回true，否则返回错误原因
     */
    public function tryLoginAdmin(string $username, string $password)
    {
        $json = file_get_contents(Kernel::getConfig('admin.json'));
        $admins = json_decode($json, true);
        foreach ($admins as $admin) {
            if ($username !== $admin['username']) {
                return 'Invalid user name';
            } else {
                if (!password_verify($password, $admin['password']))
                    return 'Wrong password';
                else
                    return true;
            }
        }
        return 'No administrator,please add an administrator';
    }

    /**
     * 获取关于我
     *
     * @return array 标签数组
     */
    public function getAbout(): array
    {
        return $this->getData()['about'];
    }

    /**
     * 获取全部标签
     *
     * @return array 标签数组
     */
    public function getTags(): array
    {
        return $this->getData()['tags'];
    }

    /**
     * 获取全部banner
     *
     * @return array banner数组
     */
    public function getBanners(): array
    {
        return $this->getData()['banners'];
    }

    /**
     * 将传入数据写入data.json文件
     *
     * @param array $data 传入的数据
     *
     * @return bool
     */
    private function write(array $data)
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        if (file_put_contents(Kernel::getConfig('data.json'), $json) === false) {
            $log = Kernel::newLogs('Model');
            $log->addError('data.json：写入失败');
            return false;
        } else {
            $this->data = $data;
            return true;
        }
    }

    /**
     * 更新标签数据
     *
     * @param array $tags 传入的数据
     *
     * @return bool
     */
    public function updateTags(array $tags)
    {
        $data = $this->getData();
        $data['tags'] = $tags;
        if ($this->write($data))
            return true;
        else
            return false;
    }

    /**
     * 更新banner数据
     *
     * @param array $banners 传入的数据
     *
     * @return bool
     */
    public function updateBanners(array $banners)
    {
        $data = $this->getData();
        $data['banners'] = $banners;
        if ($this->write($data))
            return true;
        else
            return false;
    }

    /**
     * 解析文章数组中标签json数据
     *
     * @param array $articles
     *
     * @return array 处理后的数组
     */
    private function wrapArticle(array $articles)
    {
        $htmlSecuritySplit = new htmlSecuritySplit();
        foreach ($articles as $key => $article) {
            if (!empty($article['content'])) {
                $articles[$key]['content'] = html_entity_decode($article['content']);
                $articles[$key]['abstract'] = $htmlSecuritySplit->cutHtml($articles[$key]['content'], 500);
            }
            if (!empty($article['tags'])) {
                $jsonArr = json_decode($article['tags'], true);
                $articles[$key]['tags'] = $jsonArr;
            }
        }
        return $articles;
    }

    /**
     * 获取最后一篇文章内容
     *
     * @return array
     */
    public function getLast(): array
    {
        $pdo = $this->getPdo();
        return $pdo->getOneRow('article', '*', null, ['aid' => 'DESC']);
    }

    /**
     * 获取文章
     *
     * @param string $aid 文章aid
     * @param string $column 查询的列
     * @param array $orderBy 排序
     *
     * @return array 查询的文章列表
     */
    public function getArticle(string $aid, string $column = '*', $orderBy = null)
    {
        $pdo = $this->getPdo();
        $result = $pdo->getOneRow('article', $column, ['aid' => $aid], $orderBy);
        return $this->wrapArticle([$result])[0];
    }

    /**
     * 获取文章列表
     *
     * @param array $where 条件
     * @param int $limit 行数限制
     * @param int $offset 偏移量
     * @param array $orderBy 排序
     *
     * @return array 查询的文章列表
     */
    public function getArticles(int $limit = 1000, int $offset = 0, array $where = null, $orderBy = ['creatDate' => 'DESC'])
    {
        $pdo = $this->getPdo();
        if ($where === null) {
            $result = $pdo->getRows(
                'article',
                '*',
                null,
                $limit,
                $offset,
                $orderBy
            );
        } else {
            $result = $pdo->search('article', '*', $where);
        }
        return $this->wrapArticle($result);
    }

    /**
     * 搜索文章
     *
     * @param array $where 条件
     * @param int $limit 行数限制
     * @param int $offset 偏移量
     * @param array $orderBy 排序
     *
     * @return array 查询的文章列表
     */
    public function search(array $where = null, int $limit = 100, int $offset = 0, array $orderBy = ['creatDate' => 'DESC'])
    {
        $pdo = $this->getPdo();
        $result = $pdo->search(
            'article',
            '*',
            $where,
            $limit,
            $offset,
            $orderBy
        );
        if (!empty($result))
            return $this->wrapArticle($result);
        else
            return null;
    }

    /**
     * 添加新的文章
     *
     * @param string $title 标题
     * @param string $original 原始内容
     * @param string $html html内容
     * @param string $tags 标签
     *
     * @return bool
     */
    public function addArticle(string $title, string $original, string $html, string $tags): bool
    {
        $pdo = $this->getPdo();
        $creatDate = date('Y-m-d H:i:s');
        $data = [
            'creatDate' => $creatDate,
            'title' => $title,
            'original' => $original,
            'content' => $html,
            'tags' => $tags
        ];
        return $pdo->insert('article', $data);
    }

    /**
     * 更改文章
     *
     * @param array $data 要更改的数据
     * @param array $aid 文章id
     *
     * @return bool
     */
    public function updateArticle(array $data, $aid): bool
    {
        $pdo = $this->getPdo();
        return $pdo->update('article', $data, ['aid' => $aid]);
    }

    /**
     * 删除一篇文章
     *
     * @param string $aid 文章id
     *
     * @return bool
     */
    public function deleteArticle(string $aid): bool
    {
        $pdo = $this->getPdo();
        return $pdo->delete('article', ['aid' => $aid]);
    }
}