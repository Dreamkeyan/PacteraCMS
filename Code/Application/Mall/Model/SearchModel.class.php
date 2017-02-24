<?php

/**
 * 搜索模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

class SearchModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_search';
    
    /**
     * 获取搜索词汇列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function getList($cate_id = 0) {
        $where = array(
            'status' => 1
        );
        if($cate_id){
            $where['category_id'] = $cate_id; 
        }
        return $this->where($where)->select();
    }

}
