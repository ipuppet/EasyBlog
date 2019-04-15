<?php


namespace EasyBlog\Core;


interface IDbHandler
{
    /**
     * 获取自身实例
     *
     * @param array $config 数据库连接信息
     * @return IDbHandler
     */
    public static function getInstance(array $config = null): IDbHandler;

    /**
     * 查询一条数据
     *
     * @param string $table 数据表
     * @param string $column 查询列
     * @param array $where 过滤条件
     * @param array $orderBy 排序
     *
     * @return array
     */
    public function getOneRow($table, $column, array $where = null, $orderBy = null);

    /**
     * 查询多条数据
     *
     * @param string $table 数据表
     * @param string $column 查询列
     * @param array $where 过滤条件
     * @param int $limit 行数限制
     * @param int $offset 偏移量
     * @param array $orderBy 排序
     *
     * @return array
     */
    public function getRows($table, $column = '*', array $where = null, int $limit = 100, int $offset = 0, array $orderBy = null);

    /**
     * 获取总行数
     *
     * @param string $table
     * @return int 总数
     */
    public function count(string $table): int;

    /**
     * 模糊查询
     *
     * @param string $table 数据表
     * @param string $column 查询列
     * @param array $where 过滤条件
     * @param int $limit 行数限制
     * @param int $offset 偏移量
     * @param array $orderBy 排序
     *
     * @return array
     */
    public function search($table, $column = '*', array $where = null, int $limit = 100, int $offset = 0, array $orderBy = null);

    /**
     * 更新数据
     *
     * @param string $table 表名
     * @param array $data 数据内容
     * @param array $where 过滤条件
     *
     * @return bool
     */
    public function update(string $table, array $data, array $where): bool;

    /**
     * 插入数据
     *
     * @param string $table 表名
     * @param array $data 数据内容
     *
     * @return bool
     */
    public function insert(string $table, array $data): bool;

    /**
     * 删除数据
     *
     * @param string $table 表名
     * @param array $where 数据内容
     *
     * @return bool
     */
    public function delete(string $table, array $where): bool;
}