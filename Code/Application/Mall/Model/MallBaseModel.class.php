<?php

/**
 * 基础模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

use Common\Model\CommonModel;
use Mall\Service\PageService;

class MallBaseModel extends CommonModel
{

    /**
     * @var
     */
    protected $page;

    /**
     * @var int
     */
    protected $pageSize = 10;

    /**
     * @var array
     */
    protected $where = array();

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @var array
     */
    protected $order = array();

    /**
     * @var bool
     */
    protected $relation = false;

    /**
     * @var array
     */
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * Search data by conditions
     *
     * @param array $params
     *
     * @return mixed
     */
    public function search(array $params = array())
    {
        if (method_exists($this, '_initSearch')) {
            $this->_initSearch();
        }
        $this->params = $params;
        if (method_exists($this, '_searchPrams')) {
            $this->_searchPrams($this->params);
        }
        $count = $this->where($this->where)->count();
        $this->page = new PageService($count, $this->pageSize, $this->params);

        $query = $this->where($this->where)->order($this->order)->limit($this->page->firstRow . ',' . $this->page->listRows);
        if ($this->relation) {
            $query = $query->relation($this->relation);
        }
        $data = $query->select();

        return method_exists($this, '_searchDataFormat') ? $this->_searchDataFormat($data) : $data;
    }

    /**
     * Get the page
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page ? $this->page->show() : '';
    }

    /**
     * Save multiple data
     *
     * @param $saveWhere
     * @param $saveData
     *
     * @return bool
     */
    public function saveAll($saveWhere, &$saveData)
    {
        if ($saveWhere == null) {
            return false;
        }
        //获取更新的主键id名称
        $key = array_keys($saveWhere)[0];
        //获取更新列表的长度
        $len = count($saveWhere[$key]);
        $flag = true;
        $model = isset($model) ? $model : M($this->tableName);
        //开启事务处理机制
        $model->startTrans();
        //记录更新失败ID
        $error = [];

        for ($i = 0; $i < $len; $i++) {
            //预处理sql语句
            $isRight = $model->where($key . '=' . $saveWhere[$key][$i])->save($saveData[$i]);
            if ($isRight == 0) {
                $error[] = $i;
                $flag = false;
            }
        }
        if ($flag) {
            //如果都成立就提交
            $model->commit();
            return $saveWhere;
        } elseif (count($error) > 0 & count($error) < $len) {
            //先将原先的预处理进行回滚
            $model->rollback();
            for ($i = 0; $i < count($error); $i++) {
                //删除更新失败的ID和Data
                unset($saveWhere[$key][$error[$i]]);
                unset($saveData[$error[$i]]);
            }
            //重新将数组下标进行排序
            $saveWhere[$key] = array_merge($saveWhere[$key]);
            $saveData = array_merge($saveData);
            //进行第二次递归更新
            $this->saveAll($saveWhere, $saveData, $this->tableName);
            return $saveWhere;
        } else {
            //如果都更新就回滚
            $model->rollback();
            return false;
        }
    }

}
