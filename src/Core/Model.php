<?php

namespace EasyBlog\Core;

use EasyBlog\Ext\htmlSecuritySplit;

class Model
{
    private $data;
    private $dbHandler;

    /**
     * 获取pdo实例
     *
     * @return IDbHandler
     */
    private function getDbHandler(): IDbHandler
    {
        if ($this->dbHandler === null) {
            $this->dbHandler = WrapPdo::getInstance();
            if (!($this->dbHandler instanceof IDbHandler)) {
                die('未能实现IDbHandler接口');
            }
        }
        return $this->dbHandler;
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
        foreach ($admins as $key => $admin) {
            if ($username !== $admin['username']) {
                return [
                    'state' => '101',
                    'msg' => '用户名错误'
                ];
            } else {
                if (!password_verify($password, $admin['password'])) {
                    return [
                        'state' => '102',
                        'msg' => '密码错误'
                    ];
                } else {
                    if (password_needs_rehash($admin['password'], PASSWORD_DEFAULT)) {
                        $admins[$key]['password'] = password_hash($password, PASSWORD_DEFAULT);
                        file_put_contents(Kernel::getConfig('admin.json'), json_encode($admins));
                    }
                    return [
                        'state' => '0',
                        'msg' => 'Success'
                    ];
                }
            }
        }
        return [
            'state' => '103',
            'msg' => 'No administrator,please add an administrator'
        ];
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
        $dbHandler = $this->getDbHandler();
        return $dbHandler->getOneRow('article', '*', null, ['aid' => 'DESC']);
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
        $dbHandler = $this->getDbHandler();
        $result = $dbHandler->getOneRow('article', $column, ['aid' => $aid], $orderBy);
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
        $dbHandler = $this->getDbHandler();
        if ($where === null) {
            $result = $dbHandler->getRows(
                'article',
                '*',
                null,
                $limit,
                $offset,
                $orderBy
            );
        } else {
            $result = $dbHandler->search('article', '*', $where);
        }
        return $this->wrapArticle($result);
    }

    /**
     * 文章分页
     *
     * @param int $num 每页数量
     * @param int $page 当前页
     * @param array $where 限定条件
     * @param array $orderBy 排序
     *
     * @return array 查询的文章列表
     */
    public function paging(int $num, int $page = 1, array $where = null, $orderBy = ['creatDate' => 'DESC'])
    {
        $dbHandler = $this->getDbHandler();
        $articles = $dbHandler->getRows(
            'article',
            '*',
            $where,
            $num,
            ($page - 1) * $num,
            $orderBy
        );
        $result = [
            'articles' => $this->wrapArticle($articles),
            'pageCount' => (int)ceil($this->getCount() / $num)
        ];
        return $result;
    }

    /**
     * 获取文章总数
     *
     * @return int 总数
     */
    public function getCount(): int
    {
        $dbHandler = $this->getDbHandler();
        return $dbHandler->count('article');
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
        $dbHandler = $this->getDbHandler();
        $result = $dbHandler->search(
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
        $dbHandler = $this->getDbHandler();
        $creatDate = date('Y-m-d H:i:s');
        $data = [
            'creatDate' => $creatDate,
            'title' => $title,
            'original' => $original,
            'content' => $html,
            'tags' => $tags
        ];
        return $dbHandler->insert('article', $data);
    }

    /**
     * 更改文章
     *
     * @param array $data 要更改的数据
     * @param int $aid 文章id
     *
     * @return bool
     */
    public function updateArticle(array $data, int $aid): bool
    {
        $dbHandler = $this->getDbHandler();
        return $dbHandler->update('article', $data, ['aid' => $aid]);
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
        $dbHandler = $this->getDbHandler();
        return $dbHandler->delete('article', ['aid' => $aid]);
    }
}