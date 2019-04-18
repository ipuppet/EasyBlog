<?php

namespace EasyBlog\Core;

use PDO;
use PDOException;

/*
 * WrapPdo使用方法
 *
 * 调用静态方法\App\Core\WrapPdo::getInstance()获取实例
*/

final class WrapPdo implements IDbHandler
{
    private $pdo;
    private $log;
    private $config;
    private static $instance;

    private function __construct(array $config = null)
    {
        //获取连接信息
        $config = $this->config($config);
        try {
            //database默认值mysql
            $config['database'] = isset($config['database']) ? $config['database'] : 'mysql1';
            $this->pdo = new PDO(
                sprintf(
                    '%s:host=%s;dbname=%s;port=%s;charset=%s',
                    $config['database'],
                    $config['host'],
                    $config['dbname'],
                    $config['port'],
                    $config['charset']
                ),
                $config['username'],
                $config['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //记录日志
            $this->getLog()->addError('Connect failed: ' . $e->getMessage());
            die($e->getMessage());
        }
    }

    private function getLog()
    {
        //初始化Monolog
        if ($this->log === null)
            $this->log = Kernel::newLogs('database');
        return $this->log;
    }

    /*
     * 存储数据库连接信息
     *
     * @param array $config
     */
    private function config(array $config = null)
    {
        //优先从配置文件读取数据库连接信息
        if ($this->config === null)
            $this->config = include Kernel::getConfig('database');
        //如果有传入的配置则进行增改
        if ($config !== null) {
            foreach ($config as $k => $v) {
                $this->config[$k] = $v;
            }
        }
        return $this->config;
    }

    private function __clone()
    {
    }

    /*
     * 封装表名或者列
     *
     * @param mixed $param 数据
     */
    private function dealParam($param, $space = '`')
    {
        if (is_array($param)) {
            $str = $space . implode("{$space},{$space}", $param) . $space;
        } else {
            $arr = explode(',', $param);
            $str = $space . implode("{$space},{$space}", $arr) . $space;
        }
        return $str;
    }

    /**
     * 执行数据库操作
     *
     * @param string $table 数据表
     * @param string $column 查询列
     * @param array $where 过滤条件
     * @param int $limit 行数限制
     * @param int $offset 偏移量
     * @param bool $fuzzy 是否模糊查找
     * @param array $orderBy 排序
     *
     * @return array
     */
    private function query($table, $column, array $where = null, int $limit = 100, int $offset = 0, bool $fuzzy = false, array $orderBy = null)
    {
        //初始化值，其中bind存储where信息
        $bind = null;
        $result = null;
        $table = $this->dealParam($table);
        $column = $this->dealParam($column, '');
        $sql = "SELECT {$column} FROM {$table}";
        //拼接sql语句
        if ($where !== null) {
            $whereArr = [];
            $len = count($where);
            $param = array_keys($where);
            for ($i = 0; $i < $len; $i++) {
                //$bind 绑定数据
                //$whereArr where语句片段
                if ($fuzzy) {
                    $whereArr[] = "`{$param[$i]}` LIKE :v{$i}";
                    $bind[":v{$i}"] = '%' . $where[$param[$i]] . '%';
                } else {
                    $whereArr[] = "`{$param[$i]}`=:v{$i}";
                    $bind[":v{$i}"] = $where[$param[$i]];
                }
            }
            //将where用AND连接，并和$sql连接
            $sql .= ' WHERE ' . implode($whereArr, ' AND ');
        }
        /*判断是否要求排序*/
        $orderByStr = '';
        if (null !== $orderBy) {
            $orderByArr = [];
            foreach ($orderBy as $k => $v) {
                $orderByArr[] = "`{$k}` {$v}";
            }
            $orderByStr = ' ORDER BY ' . implode(',', $orderByArr);
        }
        $sql .= $orderByStr . " LIMIT {$offset},{$limit}";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($bind);
            //迭代结果
            while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
                $result[] = $row;
            }
        } catch (PDOException $e) {
            $mse = $e->getMessage();
            $code = $e->getCode();
            $errStr = "Query error: ErrorMessage: {$mse} ErrorCode: {$code}";
            //记录日志
            $this->getLog()->addError($errStr);
        }
        return $result;
    }

    /**
     * 获取自身实例
     *
     * @param array $config 数据库连接信息
     * @return WrapPdo
     */
    public static function getInstance(array $config = null): IDbHandler
    {
        if (self::$instance === null)
            self::$instance = new self($config);
        return self::$instance;
    }

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
    public function getOneRow($table, $column, array $where = null, $orderBy = null)
    {
        $result = $this->query($table, $column, $where, 1, 0, false, $orderBy)[0];
        return $result;
    }

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
    public function getRows($table, $column = '*', array $where = null, int $limit = 100, int $offset = 0, array $orderBy = null)
    {
        $result = $this->query($table, $column, $where, $limit, $offset, false, $orderBy);
        return $result;
    }

    /**
     * 获取总行数
     *
     * @param string $table
     * @return int 总数
     */
    public function count(string $table): int
    {
        $sql = "SELECT count(*) as count FROM {$table}";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            //迭代结果
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $mse = $e->getMessage();
            $code = $e->getCode();
            $errStr = "Query error: ErrorMessage: {$mse} ErrorCode: {$code}";
            //记录日志
            $this->getLog()->addError($errStr);
        }
        return (int)$result['count'];
    }

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
    public function search($table, $column = '*', array $where = null, int $limit = 100, int $offset = 0, array $orderBy = null)
    {
        $result = $this->query($table, $column, $where, $limit, $offset, true, $orderBy);
        return $result;
    }

    /**
     * 更新数据
     *
     * @param string $table 表名
     * @param array $data 数据内容
     * @param array $where 过滤条件
     *
     * @return bool
     */
    public function update(string $table, array $data, array $where): bool
    {
        $sql = "UPDATE {$table} SET ";
        $dataArr = [];
        foreach ($data as $k => $v) {
            $dataArr[] = "`{$k}`='{$v}'";
        }
        $dataStr = implode(',', $dataArr);
        $sql .= $dataStr;
        $bind = [];
        if ($where !== null) {
            $whereArr = [];
            $len = count($where);
            $param = array_keys($where);
            for ($i = 0; $i < $len; $i++) {
                //$bind 绑定数据
                //$whereArr where语句片段
                $whereArr[] = "`{$param[$i]}`=:v{$i}";
                $bind[":v{$i}"] = $where[$param[$i]];
            }
            //将where用AND连接，并和$sql连接
            $sql .= ' WHERE ' . implode($whereArr, ' AND ');
        }
        $result = false;
        try {
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($bind);
        } catch (PDOException $e) {
            $mse = $e->getMessage();
            $code = $e->getCode();
            $errStr = "Query error: ErrorMessage: {$mse} ErrorCode: {$code}";
            //记录日志
            $this->getLog()->addError($errStr);
        }
        return $result;
    }

    /**
     * 插入数据
     *
     * @param string $table 表名
     * @param array $data 数据内容
     *
     * @return bool
     */
    public function insert(string $table, array $data): bool
    {
        $sql = "INSERT INTO {$table}";
        $i = 0;
        $key = [];
        $val = [];
        $bind = [];
        foreach ($data as $k => $v) {
            $key[] = "`{$k}`";
            $val[] = ":v{$i}";
            $bind[":v{$i}"] = $data[$k];
            $i++;
        }
        $keyStr = '(' . implode(',', $key) . ')';
        $valStr = '(' . implode(',', $val) . ')';
        $sql = $sql . $keyStr . ' VALUES ' . $valStr;
        $result = false;
        try {
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($bind);
        } catch (PDOException $e) {
            $mse = $e->getMessage();
            $code = $e->getCode();
            $errStr = "Query error: ErrorMessage: {$mse} ErrorCode: {$code}";
            //记录日志
            $this->getLog()->addError($errStr);
        }
        return $result;
    }

    /**
     * 删除数据
     *
     * @param string $table 表名
     * @param array $where 数据内容
     *
     * @return bool
     */
    public function delete(string $table, array $where): bool
    {
        $len = count($where);
        $param = array_keys($where);
        $bind = [];
        $whereArr = [];
        for ($i = 0; $i < $len; $i++) {
            //$bind 绑定数据
            //$whereArr where语句片段
            $whereArr[] = "`{$param[$i]}`=:v{$i}";
            $bind[":v{$i}"] = $where[$param[$i]];
        }
        //将where用AND连接，并和$sql连接
        $sql = "DELETE FROM {$table} WHERE " . implode($whereArr, ' AND ');
        $result = false;
        try {
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($bind);
        } catch (PDOException $e) {
            $mse = $e->getMessage();
            $code = $e->getCode();
            $errStr = "Query error: ErrorMessage: {$mse} ErrorCode: {$code}";
            //记录日志
            $this->getLog()->addError($errStr);
        }
        return $result;
    }
}