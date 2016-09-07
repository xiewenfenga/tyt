<?php
/*********************************************************************************
 *  PhpStorm - phpad
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By cw100.com
 * 文件内容简单说明
 *-------------------------------------------------------------------------------
 * $FILE:BaseModel.php
 * $Author:zxs
 * $Dtime:2016/9/7
 ***********************************************************************************/

namespace App\Models;


use App\Eloquent\Model;

class BaseModel extends  Model
{
    /**
     * @param array $fields
     * @param array $where
     * @param array $orderBy
     * @param array $groupBy
     * @param int $pagesize
     * @param null $page
     * @return mixed
     * 返回数据模型列表
     */
    public function lists($fields = ['*'], $where = [], $orderBy = [], $groupBy = [], $pagesize = 10, $page = null)
    {
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
            $fields = array_map('trim', $fields);
        }
        $query = $this->select($fields);
        $query = $this->createWhere($query, $where, $orderBy, $groupBy);
        if (isset($page)) {
            $limit = $pagesize * ($page - 1);
            $result = $query->skip($limit)->take($pagesize)->get();
        } else {
            $result = $query->paginate($pagesize);
        }
        return $result;
    }

    /**
     * @param $query
     * @param array $where
     * @param array $orderBy
     * @param array $groupBy
     * @return mixed
     * 设置where条件
     */
    public function createWhere($query, $where = [], $orderBy = [], $groupBy = [])
    {
        if (isset($where['in'])) {
            foreach ($where['in'] as $k => $v) {
                $query = $query->whereIn($k, $v);
            }
            unset($where['in']);
        }
        if (isset($where['not_in'])) {
            foreach ($where['not_in'] as $k => $v) {
                $query = $query->whereNotIn($k, $v);
            }
            unset($where['not_in']);
        }
        if (isset($where['raw'])) {
            foreach ($where['raw'] as $k => $v) {
                $query = $query->whereRaw($v);
            }
            unset($where['raw']);
        }
        if (isset($where['null'])) {
            foreach ($where['null'] as $k => $v) {
                $query = $query->whereNull($v);
            }
            unset($where['null']);
        }
        if (isset($where['not_null'])) {
            foreach ($where['not_null'] as $k => $v) {
                $query = $query->whereNotNull($v);
            }
            unset($where['not_null']);
        }
        if (isset($where['between'])) {
            foreach ($where['between'] as $k => $v) {
                $query = $query->whereBetween($k, $v);
            }
            unset($where['between']);
        }
        if ($where) {
            foreach ($where as $k => $v) {
                $operator = '=';
                if (substr($k, -2) == ' <') {
                    $k = trim(str_replace(' <', '', $k));
                    $operator = '<';
                } elseif (substr($k, -3) == ' <=') {
                    $k = trim(str_replace(' <=', '', $k));
                    $operator = '<=';
                } elseif (substr($k, -2) == ' >') {
                    $k = trim(str_replace(' >', '', $k));
                    $operator = '>';
                } elseif (substr($k, -3) == ' >=') {
                    $k = trim(str_replace(' >=', '', $k));
                    $operator = '>=';
                } elseif (substr($k, -3) == ' !=') {
                    $k = trim(str_replace(' !=', '', $k));
                    $operator = '!=';
                } elseif (substr($k, -3) == ' <>') {
                    $k = trim(str_replace(' <>', '', $k));
                    $operator = '<>';
                } elseif (substr($k, -5) == ' like') {
                    $k = trim(str_replace(' like', '', $k));
                    $operator = 'like';
                    $v = '%' . $v . '%';
                }
                $query = $query->where($k, $operator, $v);
            }
        }
        if ($orderBy) {
            foreach ($orderBy as $k => $v) {
                $query = $query->orderBy($k, $v);
            }
        }
        if ($groupBy) {
            $query = $query->groupBy($groupBy);
        }
        return $query;
    }
}