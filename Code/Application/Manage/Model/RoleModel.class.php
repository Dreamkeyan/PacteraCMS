<?php

/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Model;

use Common\Model\CommonModel;

class  RoleModel extends CommonModel{
     protected $pk   = 'role_id';
     protected $tableName =  'manage_role';
     protected $token = 'manage_role';

    /**
     * 分页的基本条件和排序方式
     *
     * @author: xiongfei.ma@pactera.com
     *
     * @date: 2016年12月2日14:47:41
     * @param $map
     * @param $orderBy
     */
    protected function _initSearch($map,$orderBy)
    {
        $this->where = $map;
        $this->order = $orderBy;
    }

    /**
     * 前台数据拼装的查询条件
     *
     * @author: xiongfei.ma@pactera.com
     *
     * @date: 2016年12月2日14:47:59
     * @param array $params
     */
    protected function _searchPrams(array $params = array())
    {
        if ($params['name']) {
            $this->where['role_name'] = array('like', '%' . $params['name'] . '%');
        }
    }
}