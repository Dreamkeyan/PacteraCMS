<?php

/**
 *
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Common\Model;

use Manage\Service\PageService;
use Think\Model\RelationModel;

class CommonModel extends RelationModel
{
    protected $pk = '';
    protected $tableName = '';
    protected $token = '';
    protected $cacheTime = 86400;
    protected $orderby = array(); //针对全部查询出的数据的排序
    protected $_validate = array();

    protected $page;
    protected $pageSize = 15;
    protected $where = array();
    protected $params = array();
    protected $order = array();

    /**
     * 分页操作
     *
     * @author: xiongfei.ma@pactera.com
     *
     * @date: 2016年12月2日14:45:24
     * @param $params   通过前台传递的查询条件，
     * @param $map      当前模块的查询条件
     * @param $orderBy  排序字段
     * @return mixed
     */
    public function toPage($params,$map,$orderBy)
    {
        if (method_exists($this, '_initSearch')) {
            $this->_initSearch($map,$orderBy);
        }
        $this->params = $params;
        if (method_exists($this, '_searchPrams')) {
            $this->_searchPrams($this->params);
        }
        $count = $this->where($this->where)->count();
        $this->page = new PageService($count, $this->pageSize, $this->params);
        return $this->where($this->where)->order($this->order)->limit($this->page->firstRow . ',' . $this->page->listRows)->select();
    }

    public function getPage()
    {
        return $this->page ? $this->page->show() : '';
    }


    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    public function updateCount($id, $col, $num = 1)
    {
        $id = (int)$id;
        return $this->execute(" update " . $this->getTableName() . " set {$col} = ({$col} + '{$num}') where " . $this->pk . " = '{$id}' ");
    }

    public function itemsByIds($ids = array())
    {
        if (empty($ids)) return array();
        $data = $this->where(array($this->pk => array('IN', $ids)))->select();
        $return = array();
        foreach ($data as $val) {
            $return[$val[$this->pk]] = $val;
        }
        return $return;
    }

    public function fetchAll()
    {
        $cache = S(array('type' => 'File', 'expire' => $this->cacheTime));
        if (!$data = $cache->get($this->token)) {
            $result = $this->order($this->orderby)->select();
            $data = array();
            foreach ($result as $row) {
                $data[$row[$this->pk]] = $this->_format($row);
            }
            $cache->set($this->token, $data);
        }
        return $data;
    }

    public function cleanCache()
    {
        $cache = S(array('type' => 'File', 'expire' => $this->cacheTime));
        $cache->rm($this->token);
    }

    public function _format($data)
    {
        return $data;
    }

}